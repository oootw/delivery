<?php

declare(strict_types=1);

namespace App\Application\Promotion\Entity\Promotion;

/**
 * Одна применённая акция с посчитанной скидкой — элемент результата движка.
 */
final class AppliedPromotion
{
    public function __construct(
        public readonly int $promotionId,
        public readonly string $name,
        public readonly int $discountKopecks,
    ) {}
}
