<?php

declare(strict_types=1);

namespace App\Application\Venue\Command\SetVenueWorkingHours;

use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Venue\Service\WorkingHoursRule;
use App\Application\Workspace\Service\WorkspaceAccess;

class SetVenueWorkingHoursHandler
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly WorkingHoursRule $workingHoursRule,
    ) {}

    public function handle(SetVenueWorkingHoursCommand $command): void
    {
        $venue = $this->venues->findById($command->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $venue->workspaceId,
            userId: $command->ownerId,
        );

        $venue->setWorkingHours($this->workingHoursRule->build($command->workingHours));

        $this->venues->save($venue);
    }
}
