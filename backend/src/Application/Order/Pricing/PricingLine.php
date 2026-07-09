<?php

declare(strict_types=1);

namespace App\Application\Order\Pricing;

/**
 * Строка заказа для расчёта скидок на позиции/категории: идентификатор позиции,
 * её категория и стоимость строки (позиция + модификаторы, с учётом количества).
 */
final class PricingLine
{
    public function __construct(
        public readonly string $menuItemExternalId,
        public readonly string $categoryExternalId,
        public readonly int $lineTotalKopecks,
    ) {}
}
