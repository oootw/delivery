<?php

declare(strict_types=1);

namespace App\Application\Menu\Service;

/**
 * Результат расчёта цены комбо от актуального меню. isAvailable = false, если хотя бы
 * один вложенный товар отсутствует в меню или снят со стоп-листа — тогда комбо заказать нельзя.
 */
final class ComboPrice
{
    public function __construct(
        public readonly int $subtotalKopecks,
        public readonly int $discountKopecks,
        public readonly int $priceKopecks,
        public readonly bool $isAvailable,
    ) {}
}
