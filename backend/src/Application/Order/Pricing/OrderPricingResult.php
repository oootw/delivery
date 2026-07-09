<?php

declare(strict_types=1);

namespace App\Application\Order\Pricing;

/**
 * Результат расчёта скидок: итоговая скидка и разбивка по применённым акциям.
 */
final class OrderPricingResult
{
    /**
     * @param AppliedDiscount[] $appliedDiscounts
     */
    public function __construct(
        public readonly int $discountKopecks,
        public readonly array $appliedDiscounts,
    ) {}

    /**
     * @return array<int, array{promotion_id: int, name: string, discount_kopecks: int}>
     */
    public function toArray(): array
    {
        return array_map(
            static fn(AppliedDiscount $discount): array => $discount->toArray(),
            $this->appliedDiscounts,
        );
    }
}
