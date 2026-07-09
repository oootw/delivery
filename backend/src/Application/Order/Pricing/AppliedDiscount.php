<?php

declare(strict_types=1);

namespace App\Application\Order\Pricing;

/**
 * Снимок одной применённой скидки — сохраняется в заказе как история расчёта.
 */
final class AppliedDiscount
{
    public function __construct(
        public readonly int $promotionId,
        public readonly string $name,
        public readonly int $discountKopecks,
    ) {}

    /**
     * @return array{promotion_id: int, name: string, discount_kopecks: int}
     */
    public function toArray(): array
    {
        return [
            'promotion_id' => $this->promotionId,
            'name' => $this->name,
            'discount_kopecks' => $this->discountKopecks,
        ];
    }
}
