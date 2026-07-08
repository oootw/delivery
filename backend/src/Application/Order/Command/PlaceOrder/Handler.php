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
        $total = 0;

        foreach ($command->lines as $line) {
            $orderItem = $this->buildOrderItem($line, $availableItems, $availableModifiers);
            $orderItems[] = $orderItem;
            $total += $orderItem->lineTotalKopecks();
        }

        $order = Order::buildNew(
            workspaceId: $venue->workspaceId,
            venueId: $venue->id,
            customerId: $command->customerId,
            type: $type,
            items: $orderItems,
            totalKopecks: $total,
            contactName: $command->contactName,
            contactPhone: $command->contactPhone,
            deliveryAddress: $deliveryAddress,
            comment: $command->comment,
            invoiceId: Uuid::v4()->toRfc4122(),
        );

        $orderId = $this->orders->save($order);

        return new PlacedOrderDTO(
            orderId: $orderId,
            invoiceId: $order->invoiceId,
            accountId: $command->customerId,
            totalKopecks: $total,
            amountRubles: number_format($total / 100, 2, '.', ''),
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
