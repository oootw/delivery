<?php

declare(strict_types=1);

namespace App\Application\Order\Command\PlaceOrder;

use App\Application\Menu\Entity\MenuItem\MenuItem;
use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use App\Application\Menu\Entity\Modifier\Modifier;
use App\Application\Menu\Entity\Modifier\ModifierRepositoryInterface;
use App\Application\Order\Entity\Order\Order;
use App\Application\Order\Entity\Order\OrderItem;
use App\Application\Order\Entity\Order\OrderItemModifier;
use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Entity\Order\OrderTypeEnum;
use App\Application\Order\Pricing\OrderPricingInterface;
use App\Application\Order\Pricing\OrderPricingRequest;
use App\Application\Order\Pricing\PricingLine;
use App\Application\Order\Rewards\OrderRewardsInterface;
use App\Application\Order\Rewards\RedeemQuoteRequest;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Оформление заказа. Цены и названия берутся из актуального меню точки и
 * фиксируются в заказе; сумма считается на сервере. Заказ создаётся в статусе
 * «created» и ждёт онлайн-оплаты — платёжные реквизиты возвращаются виджету.
 */
class Handler
{
    private const CURRENCY = 'RUB';

    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly MenuItemRepositoryInterface $menuItems,
        private readonly ModifierRepositoryInterface $modifiers,
        private readonly OrderRepositoryInterface $orders,
        private readonly OrderPricingInterface $orderPricing,
        private readonly OrderRewardsInterface $orderRewards,
    ) {}

    public function handle(Command $command): PlacedOrderDTO
    {
        $venue = $this->venues->findById($command->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        if (!$venue->isActive) {
            throw new \DomainException('Точка сейчас не принимает заказы');
        }

        $type = OrderTypeEnum::tryFrom($command->type);

        if ($type === null) {
            throw new \DomainException('Неизвестный тип заказа');
        }

        if ($type === OrderTypeEnum::Delivery && !$venue->supportsDelivery) {
            throw new \DomainException('Точка не работает на доставку');
        }

        if ($type === OrderTypeEnum::Pickup && !$venue->supportsPickup) {
            throw new \DomainException('Точка не работает на самовывоз');
        }

        $deliveryAddress = $command->deliveryAddress;

        if ($type === OrderTypeEnum::Delivery && ($deliveryAddress === null || trim($deliveryAddress) === '')) {
            throw new \DomainException('Укажите адрес доставки');
        }

        if ($type === OrderTypeEnum::Pickup) {
            $deliveryAddress = null;
        }

        if ($command->lines === []) {
            throw new \DomainException('Заказ пустой');
        }

        $availableItems = $this->indexItemsByExternalId($command->venueId);
        $availableModifiers = $this->indexModifiersByExternalId($command->venueId);

        $orderItems = [];
        $pricingLines = [];
        $subtotal = 0;

        foreach ($command->lines as $line) {
            $orderItem = $this->buildOrderItem($line, $availableItems, $availableModifiers);
            $orderItems[] = $orderItem;
            $subtotal += $orderItem->lineTotalKopecks();

            $pricingLines[] = new PricingLine(
                menuItemExternalId: $orderItem->menuItemExternalId,
                categoryExternalId: $availableItems[$line->menuItemExternalId]->categoryExternalId,
                lineTotalKopecks: $orderItem->lineTotalKopecks(),
            );
        }

        // Постоянная скидка уровня лояльности гостя — учитывается движком скидок.
        $tierDiscount = $this->orderRewards->currentTierDiscount($venue->workspaceId, $command->customerId);

        $pricingRequest = new OrderPricingRequest(
            workspaceId: $venue->workspaceId,
            venueId: $venue->id,
            customerId: $command->customerId,
            orderType: $type->value,
            subtotalKopecks: $subtotal,
            promocode: $command->promocode,
            now: new \DateTimeImmutable(),
            timezone: $venue->timezone,
            isFirstOrder: !$this->orders->hasPaidOrBeyondByCustomer($venue->workspaceId, $command->customerId),
            lines: $pricingLines,
            tierDiscountBasisPoints: $tierDiscount->basisPoints,
            tierName: $tierDiscount->tierName,
        );

        $pricing = $this->orderPricing->priceOrder($pricingRequest);
        $payableAfterPromo = max(0, $subtotal - $pricing->discountKopecks);

        // Списание баллов идёт поверх скидок, от суммы к оплате после промо.
        $redeemRequest = new RedeemQuoteRequest(
            workspaceId: $venue->workspaceId,
            customerId: $command->customerId,
            pointsToSpend: $command->pointsToSpend ?? 0,
            maxBaseKopecks: $payableAfterPromo,
        );

        $redeem = $this->orderRewards->quoteRedeem($redeemRequest);
        $payable = max(0, $payableAfterPromo - $redeem->pointsDiscountKopecks);

        $order = Order::buildNew(
            workspaceId: $venue->workspaceId,
            venueId: $venue->id,
            customerId: $command->customerId,
            type: $type,
            items: $orderItems,
            subtotalKopecks: $subtotal,
            discountKopecks: $pricing->discountKopecks,
            appliedDiscounts: $pricing->toArray(),
            pointsSpent: $redeem->pointsSpent,
            pointsDiscountKopecks: $redeem->pointsDiscountKopecks,
            contactName: $command->contactName,
            contactPhone: $command->contactPhone,
            deliveryAddress: $deliveryAddress,
            comment: $command->comment,
            invoiceId: Uuid::v4()->toRfc4122(),
        );

        $orderId = $this->orders->save($order);

        // Скидка применилась — фиксируем в леджере и счётчиках лимитов.
        $this->orderPricing->recordApplied($orderId, $pricingRequest, $pricing);

        // Резервируем списываемые баллы под заказ (спишутся при оплате).
        $this->orderRewards->reserveOnPlace($orderId, $redeemRequest, $redeem);

        return new PlacedOrderDTO(
            orderId: $orderId,
            invoiceId: $order->invoiceId,
            accountId: $command->customerId,
            totalKopecks: $payable,
            amountRubles: number_format($payable / 100, 2, '.', ''),
            currency: self::CURRENCY,
        );
    }

    /**
     * @param array<string, MenuItem> $availableItems
     * @param array<string, Modifier> $availableModifiers
     */
    private function buildOrderItem(PlaceOrderLine $line, array $availableItems, array $availableModifiers): OrderItem
    {
        if ($line->quantity < 1) {
            throw new \DomainException('Количество позиции должно быть больше нуля');
        }

        $menuItem = $availableItems[$line->menuItemExternalId] ?? null;

        if ($menuItem === null || !$menuItem->isAvailable) {
            throw new \DomainException('Позиция недоступна: ' . $line->menuItemExternalId);
        }

        $chosenModifiers = [];

        foreach ($line->modifierExternalIds as $modifierExternalId) {
            $modifier = $availableModifiers[$modifierExternalId] ?? null;

            if ($modifier === null) {
                throw new \DomainException('Модификатор недоступен: ' . $modifierExternalId);
            }

            if (!in_array($modifier->modifierGroupExternalId, $menuItem->modifierGroupExternalIds, true)) {
                throw new \DomainException('Модификатор не относится к позиции: ' . $modifierExternalId);
            }

            $chosenModifiers[] = new OrderItemModifier(
                externalId: $modifier->externalId,
                name: $modifier->name,
                priceKopecks: $modifier->priceKopecks,
            );
        }

        return new OrderItem(
            menuItemExternalId: $menuItem->externalId,
            name: $menuItem->name,
            unitPriceKopecks: $menuItem->priceKopecks,
            quantity: $line->quantity,
            modifiers: $chosenModifiers,
        );
    }

    /**
     * @return array<string, MenuItem>
     */
    private function indexItemsByExternalId(int $venueId): array
    {
        $indexed = [];

        foreach ($this->menuItems->findActiveByVenue($venueId) as $item) {
            $indexed[$item->externalId] = $item;
        }

        return $indexed;
    }

    /**
     * @return array<string, Modifier>
     */
    private function indexModifiersByExternalId(int $venueId): array
    {
        $indexed = [];

        foreach ($this->modifiers->findActiveByVenue($venueId) as $modifier) {
            $indexed[$modifier->externalId] = $modifier;
        }

        return $indexed;
    }
}
