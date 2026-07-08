<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Command\ConnectPos;

use App\Application\PosIntegration\Entity\PosConnection\PosConnection;
use App\Application\PosIntegration\Entity\PosConnection\PosConnectionRepositoryInterface;
use App\Application\PosIntegration\Entity\PosConnection\PosSystemEnum;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

class Handler
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly PosConnectionRepositoryInterface $posConnections,
    ) {}

    public function handle(Command $command): int
    {
        $posSystem = PosSystemEnum::tryFrom($command->posSystem);

        if ($posSystem === null) {
            throw new \DomainException('Неизвестная POS-система');
        }

        $venue = $this->venues->findById($command->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $venue->workspaceId,
            userId: $command->ownerId,
        );

        $connection = $this->posConnections->findByVenue($command->venueId);

        if ($connection === null) {
            $connection = PosConnection::buildNew(
                venueId: $command->venueId,
                posSystem: $posSystem,
                apiLogin: $command->apiLogin,
                organizationId: $command->organizationId,
                externalMenuId: $command->externalMenuId,
            );
        } else {
            $connection->reconfigure(
                apiLogin: $command->apiLogin,
                organizationId: $command->organizationId,
                externalMenuId: $command->externalMenuId,
            );
        }

        return $this->posConnections->save($connection);
    }
}
