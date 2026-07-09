<?php

declare(strict_types=1);

namespace App\Application\Order\Rewards;

/**
 * Результат расчёта списания: сколько баллов спишется и на какую сумму (в копейках).
 */
final class RedeemQuoteResult
{
    public function __construct(
        public readonly int $pointsSpent,
        public readonly int $pointsDiscountKopecks,
    ) {}
}
