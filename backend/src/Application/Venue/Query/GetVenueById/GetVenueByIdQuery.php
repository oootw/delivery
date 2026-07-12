<?php

declare(strict_types=1);

namespace App\Application\Venue\Query\GetVenueById;

class GetVenueByIdQuery
{
    public function __construct(
        public readonly int $userId,
        public readonly int $venueId,
    ) {}
}
