<?php

declare(strict_types=1);

namespace App\Application\Promotion\Entity\Promotion;

/**
 * Строка корзины для расчёта скидок на позиции/категории. Держится независимой
 * от домена Order (адаптер PromotionPricing маппит сюда данные заказа).
 */
final class CartLine
{
    public function __construct(
        public readonly string $menuItemExternalId,
        public readonly string $categoryExternalId,
        public readonly int $lineTotalKopecks,
    ) {}
}
