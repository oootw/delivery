<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetClientVenuesByWorkspaceId;

class GetClientVenuesByWorkspaceIdQuery
{
    public function __construct(
        public readonly int $workspaceId,
    ) {}
}
