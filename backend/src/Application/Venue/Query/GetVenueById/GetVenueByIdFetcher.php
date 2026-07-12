<?php

declare(strict_types=1);

namespace App\Application\Venue\Query\GetVenueById;

use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Venue\Query\VenueView;
use App\Application\Workspace\Service\WorkspaceAccess;

class GetVenueByIdFetcher
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function fetch(GetVenueByIdQuery $query): VenueView
    {
        $venue = $this->venues->findById($query->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $this->workspaceAccess->requireMember(
            workspaceId: $venue->workspaceId,
            userId: $query->userId,
        );

        return VenueView::fromVenue($venue);
    }
}
