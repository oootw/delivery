<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetClientVenuesByWorkspaceId;

use App\Application\Menu\Client\ClientMenuAccess;
use App\Application\Venue\Entity\Venue\Venue;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;

/**
 * Витрина точек бренда для клиента: активные точки воркспейса сервера.
 */
class GetClientVenuesByWorkspaceIdFetcher
{
    public function __construct(
        private readonly ClientMenuAccess $access,
        private readonly VenueRepositoryInterface $venues,
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetch(GetClientVenuesByWorkspaceIdQuery $query): array
    {
        $workspace = $this->access->workspaceById($query->workspaceId);

        $venues = array_filter(
            $this->venues->findAllByWorkspace((int) $workspace->id),
            static fn(Venue $venue): bool => $venue->isActive,
        );

        return array_map(
            static fn(Venue $venue): array => [
                'id' => $venue->id,
                'name' => $venue->name,
                'address' => $venue->address,
                'latitude' => $venue->latitude,
                'longitude' => $venue->longitude,
                'phone' => $venue->phone,
                'supports_delivery' => $venue->supportsDelivery,
                'supports_pickup' => $venue->supportsPickup,
            ],
            array_values($venues),
        );
    }
}
