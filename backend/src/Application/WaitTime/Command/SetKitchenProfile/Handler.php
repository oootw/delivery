<?php

declare(strict_types=1);

namespace App\Application\WaitTime\Command\SetKitchenProfile;

use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\WaitTime\Entity\KitchenProfile\KitchenProfile;
use App\Application\WaitTime\Entity\KitchenProfile\KitchenProfileRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Владелец задаёт параметры кухни точки, по которым считается время ожидания.
 * Если профиля ещё нет — создаётся из значений по умолчанию и обновляется.
 */
class Handler
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly KitchenProfileRepositoryInterface $kitchenProfiles,
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

        $profile = $this->kitchenProfiles->findByVenue($command->venueId)
            ?? KitchenProfile::buildDefault($command->venueId);

        $profile->update(
            baseMinutes: $command->baseMinutes,
            perUnitMinutes: $command->perUnitMinutes,
            parallelCapacity: $command->parallelCapacity,
            deliveryMinutes: $command->deliveryMinutes,
        );

        $this->kitchenProfiles->save($profile);
    }
}
