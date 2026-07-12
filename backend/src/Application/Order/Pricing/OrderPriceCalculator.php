<?php

declare(strict_types=1);

namespace App\Application\Order\Pricing;

use App\Application\Menu\Entity\Combo\Combo;
use App\Application\Menu\Entity\Combo\ComboRepositoryInterface;
use App\Application\Menu\Entity\MenuItem\MenuItem;
use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use App\Application\Menu\Entity\Modifier\Modifier;
use App\Application\Menu\Entity\Modifier\ModifierRepositoryInterface;
use App\Application\Menu\Service\ComboPricing;
use App\Application\Order\Entity\Order\OrderItem;
use App\Application\Order\Entity\Order\OrderItemModifier;
use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Entity\Order\OrderTypeEnum;
use App\Application\Order\Rewards\OrderRewardsInterface;
use App\Application\Order\Rewards\RedeemQuoteRequest;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;

/**
 * Единая точка расчёта цены заказа: сборка позиций по актуальному меню точки,
 * применение скидок/промокодов и списания баллов. Общий для оформления заказа
 * и предпросмотра (quote) — так итог предпросмотра совпадает с оформлением 1:1.
 *
 * Чистый расчёт без записи: побочные эффекты (леджер скидок, резерв баллов)
 * оформление вызывает отдельно, используя запросы/результаты из разбивки.
 */
class OrderPriceCalculator
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly MenuItemRepositoryInterface $menuItems,
        private readonly ModifierRepositoryInterface $modifiers,
        private readonly ComboRepositoryInterface $combos,
        private readonly ComboPricing $comboPricing,
        private readonly OrderRepositoryInterface $orders,
        private readonly OrderPricingInterface $orderPricing,
        private readonly OrderRewardsInterface $orderRewards,
    ) {}

    /**
     * @param CartLine[] $cartLines
     * @param ComboCartLine[] $comboLines
     */
    public function calculate(
        int $venueId,
        int $customerId,
        string $type,
        array $cartLines,
        ?string $promocode,
        ?int $pointsToSpend,
        array $comboLines = [],
        bool $requireVenueOpen = false,
    ): OrderPriceBreakdown {
        $venue = $this->venues->findById($venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        if (!$venue->isActive) {
            throw new \DomainException('Точка сейчас не принимает заказы');
        }

        // Проверяем только при оформлении: quote остаётся предпросмотром цены в любое время.
        if ($requireVenueOpen && !$venue->isOpenAt(new \DateTimeImmutable())) {
            throw new \DomainException('Точка сейчас закрыта');
        }

        $orderType = OrderTypeEnum::tryFrom($type);

        if ($orderType === null) {
            throw new \DomainException('Неизвестный тип заказа');
        }

        if ($orderType === OrderTypeEnum::Delivery && !$venue->supportsDelivery) {
            throw new \DomainException('Точка не работает на доставку');
        }

        if ($orderType === OrderTypeEnum::Pickup && !$venue->supportsPickup) {
            throw new \DomainException('Точка не работает на самовывоз');
        }

        if ($cartLines === [] && $comboLines === []) {
            throw new \DomainException('Заказ пустой');
        }

        $availableItems = $this->indexItemsByExternalId($venueId);
        $availableModifiers = $this->indexModifiersByExternalId($venueId);

        $orderItems = [];
        $pricingLines = [];
        $subtotal = 0;

        foreach ($cartLines as $line) {
            $orderItem = $this->buildOrderItem($line, $availableItems, $availableModifiers);
            $orderItems[] = $orderItem;
            $subtotal += $orderItem->lineTotalKopecks();

            $pricingLines[] = new PricingLine(
                menuItemExternalId: $orderItem->menuItemExternalId,
                categoryExternalId: $availableItems[$line->menuItemExternalId]->categoryExternalId,
                lineTotalKopecks: $orderItem->lineTotalKopecks(),
            );
        }

        $availableCombos = $this->indexCombosByExternalId($venueId);

        foreach ($comboLines as $comboLine) {
            $orderItem = $this->buildComboOrderItem($comboLine, $availableCombos, $availableItems);
            $orderItems[] = $orderItem;
            $subtotal += $orderItem->lineTotalKopecks();

            // У комбо нет категории меню, поэтому категорийные скидки на него не действуют.
            $pricingLines[] = new PricingLine(
                menuItemExternalId: $orderItem->menuItemExternalId,
                categoryExternalId: '',
                lineTotalKopecks: $orderItem->lineTotalKopecks(),
            );
        }

        // Постоянная скидка уровня лояльности гостя — учитывается движком скидок.
        $tierDiscount = $this->orderRewards->currentTierDiscount($venue->workspaceId, $customerId);

        $pricingRequest = new OrderPricingRequest(
            workspaceId: $venue->workspaceId,
            venueId: $venue->id,
            customerId: $customerId,
            orderType: $orderType->value,
            subtotalKopecks: $subtotal,
            promocode: $promocode,
            now: new \DateTimeImmutable(),
            timezone: $venue->timezone,
            isFirstOrder: !$this->orders->hasPaidOrBeyondByCustomer($venue->workspaceId, $customerId),
            lines: $pricingLines,
            tierDiscountBasisPoints: $tierDiscount->basisPoints,
            tierName: $tierDiscount->tierName,
        );

        $pricing = $this->orderPricing->priceOrder($pricingRequest);
        $payableAfterPromo = max(0, $subtotal - $pricing->discountKopecks);

        // Списание баллов идёт поверх скидок, от суммы к оплате после промо.
        $redeemRequest = new RedeemQuoteRequest(
            workspaceId: $venue->workspaceId,
            customerId: $customerId,
            pointsToSpend: $pointsToSpend ?? 0,
            maxBaseKopecks: $payableAfterPromo,
        );

        $redeem = $this->orderRewards->quoteRedeem($redeemRequest);
        $payable = max(0, $payableAfterPromo - $redeem->pointsDiscountKopecks);

        return new OrderPriceBreakdown(
            workspaceId: $venue->workspaceId,
            venueId: $venue->id,
            type: $orderType,
            orderItems: $orderItems,
            subtotalKopecks: $subtotal,
            discountKopecks: $pricing->discountKopecks,
            appliedDiscounts: $pricing->toArray(),
            pointsSpent: $redeem->pointsSpent,
            pointsDiscountKopecks: $redeem->pointsDiscountKopecks,
            payableKopecks: $payable,
            pricingRequest: $pricingRequest,
            pricingResult: $pricing,
            redeemRequest: $redeemRequest,
            redeemResult: $redeem,
        );
    }

    /**
     * @param array<string, MenuItem> $availableItems
     * @param array<string, Modifier> $availableModifiers
     */
    private function buildOrderItem(CartLine $line, array $availableItems, array $availableModifiers): OrderItem
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
     * @param array<string, Combo> $availableCombos
     * @param array<string, MenuItem> $availableItems
     */
    private function buildComboOrderItem(ComboCartLine $line, array $availableCombos, array $availableItems): OrderItem
    {
        if ($line->quantity < 1) {
            throw new \DomainException('Количество комбо должно быть больше нуля');
        }

        $combo = $availableCombos[$line->comboExternalId] ?? null;

        if ($combo === null) {
            throw new \DomainException('Комбо недоступно: ' . $line->comboExternalId);
        }

        $price = $this->comboPricing->price($combo, $availableItems);

        if (!$price->isAvailable) {
            throw new \DomainException('Комбо недоступно: ' . $combo->name);
        }

        // Комбо фиксируется в заказе одной позицией по серверной цене (без модификаторов).
        return new OrderItem(
            menuItemExternalId: $combo->externalId,
            name: $combo->name,
            unitPriceKopecks: $price->priceKopecks,
            quantity: $line->quantity,
            modifiers: [],
        );
    }

    /**
     * @return array<string, Combo>
     */
    private function indexCombosByExternalId(int $venueId): array
    {
        $indexed = [];

        foreach ($this->combos->findActiveByVenue($venueId) as $combo) {
            $indexed[$combo->externalId] = $combo;
        }

        return $indexed;
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
