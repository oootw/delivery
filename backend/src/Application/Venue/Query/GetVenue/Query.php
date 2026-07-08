<?php

declare(strict_types=1);

namespace App\Application\Venue\Query\GetVenue;

class Query
{
    public function __construct(
        public readonly int $userId,
        public readonly int $venueId,
    ) {}
}
