<?php

declare(strict_types=1);

namespace App\Application\Promotion\Entity\Promotion;

/**
 * Результат работы движка: суммарная скидка и список применённых акций.
 */
final class PromotionResult
{
    /**
     * @param AppliedPromotion[] $applied
     */
    public function __construct(
        public readonly int $totalDiscountKopecks,
        public readonly array $applied,
    ) {}
}
