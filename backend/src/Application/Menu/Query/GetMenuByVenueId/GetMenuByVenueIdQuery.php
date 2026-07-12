<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetMenuByVenueId;

class GetMenuByVenueIdQuery
{
    public function __construct(
        public readonly int $userId,
        public readonly int $venueId,
    ) {}
}
