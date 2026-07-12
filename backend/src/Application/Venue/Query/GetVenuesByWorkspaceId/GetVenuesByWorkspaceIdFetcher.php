<?php

declare(strict_types=1);

namespace App\Application\Venue\Query\GetVenuesByWorkspaceId;

use App\Application\Venue\Entity\Venue\Venue;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Venue\Query\VenueView;
use App\Application\Workspace\Service\WorkspaceAccess;

class GetVenuesByWorkspaceIdFetcher
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    /**
     * @return VenueView[]
     */
    public function fetch(GetVenuesByWorkspaceIdQuery $query): array
    {
        $this->workspaceAccess->requireMember(
            workspaceId: $query->workspaceId,
            userId: $query->userId,
        );

        return array_map(
            fn(Venue $venue): VenueView => VenueView::fromVenue($venue),
            $this->venues->findAllByWorkspace($query->workspaceId),
        );
    }
}
