<?php

declare(strict_types=1);

namespace App\Application\Order\Pricing;

/**
 * Вход для расчёта скидок заказа. Тип заказа передаётся строкой (значение
 * OrderTypeEnum), чтобы движок промо-акций не зависел от домена Order.
 */
final class OrderPricingRequest
{
    /**
     * @param PricingLine[] $lines
     */
    public function __construct(
        public readonly int $workspaceId,
        public readonly int $venueId,
        public readonly int $customerId,
        public readonly string $orderType,
        public readonly int $subtotalKopecks,
        public readonly ?string $promocode,
        public readonly \DateTimeImmutable $now,
        public readonly string $timezone,
        public readonly bool $isFirstOrder,
        public readonly array $lines,
    ) {}
}
