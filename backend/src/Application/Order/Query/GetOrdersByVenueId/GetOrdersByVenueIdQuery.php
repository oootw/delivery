<?php

declare(strict_types=1);

namespace App\Application\Order\Query\GetOrdersByVenueId;

class GetOrdersByVenueIdQuery
{
    public function __construct(
        public readonly int $venueId,
        public readonly int $userId,
        public readonly ?string $status,
    ) {}
}
