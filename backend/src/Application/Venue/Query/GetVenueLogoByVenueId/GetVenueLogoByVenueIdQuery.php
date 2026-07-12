<?php

declare(strict_types=1);

namespace App\Application\Venue\Query\GetVenueLogoByVenueId;

class GetVenueLogoByVenueIdQuery
{
    public function __construct(
        public readonly int $venueId,
    ) {}
}
