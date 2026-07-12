<?php

declare(strict_types=1);

namespace App\Application\Order\Pricing;

/**
 * Строка корзины с комбо: какое комбо и сколько. Цена здесь не передаётся —
 * сервер считает её от актуального меню, чтобы гость не мог её подменить.
 */
final class ComboCartLine
{
    public function __construct(
        public readonly string $comboExternalId,
        public readonly int $quantity,
    ) {}
}
