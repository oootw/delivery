<?php

declare(strict_types=1);

namespace App\Application\Venue\Query\GetVenuesByWorkspace;

class Query
{
    public function __construct(
        public readonly int $userId,
        public readonly int $workspaceId,
    ) {}
}
