<?php

declare(strict_types=1);

namespace App\Application\Menu\Service;

use App\Application\Menu\Entity\Combo\Combo;
use App\Application\Menu\Entity\Combo\ComboDiscountTypeEnum;
use App\Application\Menu\Entity\MenuItem\MenuItem;

/**
 * Считает цену комбо от актуального меню: сумма цен вложенных товаров минус скидка
 * (процент или фикс). Если хотя бы один товар недоступен — комбо помечается недоступным.
 * Общий расчёт для витрины меню и оформления заказа, чтобы цены совпадали.
 */
final class ComboPricing
{
    /**
     * @param array<string, MenuItem> $availableItemsByExternalId активные и доступные товары точки
     */
    public function price(Combo $combo, array $availableItemsByExternalId): ComboPrice
    {
        $subtotal = 0;
        $isAvailable = true;

        foreach ($combo->items as $comboItem) {
            $menuItem = $availableItemsByExternalId[$comboItem->itemExternalId] ?? null;

            if ($menuItem === null || !$menuItem->isAvailable) {
                $isAvailable = false;
                continue;
            }

            $subtotal += $menuItem->priceKopecks * $comboItem->quantity;
        }

        $discount = $this->discountKopecks($combo, $subtotal);
        $price = max(0, $subtotal - $discount);

        return new ComboPrice(
            subtotalKopecks: $subtotal,
            discountKopecks: $discount,
            priceKopecks: $price,
            isAvailable: $isAvailable && $combo->isAvailable,
        );
    }

    private function discountKopecks(Combo $combo, int $subtotal): int
    {
        return match ($combo->discountType) {
            ComboDiscountTypeEnum::Percent => intdiv($subtotal * $combo->discountValue, 100),
            ComboDiscountTypeEnum::Fixed => min($combo->discountValue, $subtotal),
        };
    }
}
