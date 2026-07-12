<?php

declare(strict_types=1);

namespace App\Application\Order\Command\PlaceOrder;

use App\Application\Order\Pricing\CartLine;
use App\Application\Order\Pricing\ComboCartLine;

class PlaceOrderCommand
{
    /**
     * @param CartLine[] $lines
     * @param ComboCartLine[] $comboLines
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
        public readonly array $comboLines = [],
    ) {}
}
