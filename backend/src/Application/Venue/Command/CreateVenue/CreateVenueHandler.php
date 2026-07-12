<?php

declare(strict_types=1);

namespace App\Application\Venue\Command\CreateVenue;

use App\Application\Venue\Entity\Venue\Venue;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Venue\Service\WorkingHoursRule;
use App\Application\Workspace\Service\WorkspaceAccess;

class CreateVenueHandler
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly WorkingHoursRule $workingHoursRule,
    ) {}

    public function handle(CreateVenueCommand $command): CreatedVenueDTO
    {
        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $command->workspaceId,
            userId: $command->ownerId,
        );

        $workingHours = $this->workingHoursRule->build($command->workingHours);

        $venue = Venue::buildNew(
            workspaceId: $command->workspaceId,
            name: $command->name,
            address: $command->address,
            latitude: $command->latitude,
            longitude: $command->longitude,
            phone: $command->phone,
            supportsDelivery: $command->supportsDelivery,
            supportsPickup: $command->supportsPickup,
            deliveryRadiusMeters: $command->deliveryRadiusMeters,
            workingHours: $workingHours,
            timezone: $command->timezone ?? 'Europe/Moscow',
        );

        $venueId = $this->venues->save($venue);

        return new CreatedVenueDTO(id: $venueId);
    }
}
