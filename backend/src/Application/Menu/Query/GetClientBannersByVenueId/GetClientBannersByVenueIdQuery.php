<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetClientBannersByVenueId;

class GetClientBannersByVenueIdQuery
{
    public function __construct(
        public readonly string $workspaceSlug,
        public readonly int $venueId,
    ) {}
}
