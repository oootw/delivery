<?php

declare(strict_types=1);

namespace App\Application\Venue\Command\UpdateVenue;

use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

class Handler
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(Command $command): void
    {
        $venue = $this->venues->findById($command->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $venue->workspaceId,
            userId: $command->ownerId,
        );

        $venue->updateDetails(
            name: $command->name,
            address: $command->address,
            latitude: $command->latitude,
            longitude: $command->longitude,
            phone: $command->phone,
            supportsDelivery: $command->supportsDelivery,
            supportsPickup: $command->supportsPickup,
            deliveryRadiusMeters: $command->deliveryRadiusMeters,
        );

        $this->venues->save($venue);
    }
}
