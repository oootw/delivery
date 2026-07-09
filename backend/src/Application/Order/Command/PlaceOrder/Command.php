<?php

declare(strict_types=1);

namespace App\Application\Order\Command\PlaceOrder;

class Command
{
    /**
     * @param PlaceOrderLine[] $lines
     */
    public function __construct(
        public readonly int $customerId,
        public readonly int $venueId,
        public readonly string $type,
        public readonly array $lines,
        public readonly string $contactName,
        public readonly string $contactPhone,
        public readonly ?string $deliveryAddress,
        public readonly ?string $comment,
        public readonly ?string $promocode = null,
        public readonly ?int $pointsToSpend = null,
    ) {}
}
