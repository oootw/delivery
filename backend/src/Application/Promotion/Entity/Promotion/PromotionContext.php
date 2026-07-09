<?php

declare(strict_types=1);

namespace App\Application\Promotion\Entity\Promotion;

/**
 * Вход для проверки условий и расчёта скидки. Держится независимым от домена Order
 * (тип заказа — строка), чтобы движок промо-акций оставался автономным и тестируемым.
 */
final class PromotionContext
{
    /**
     * @param CartLine[] $lines
     */
    public function __construct(
        public readonly int $customerId,
        public readonly string $orderType,
        public readonly int $subtotalKopecks,
        public readonly \DateTimeImmutable $now,
        public readonly string $timezone,
        public readonly bool $isFirstOrder,
        public readonly array $lines,
    ) {}
}
