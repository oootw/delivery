<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Command\RequestMenuImport;

use App\Application\PosIntegration\Entity\PosConnection\PosConnectionRepositoryInterface;
use App\Application\PosIntegration\Gateway\MenuImportQueueInterface;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

class RequestMenuImportHandler
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly PosConnectionRepositoryInterface $posConnections,
        private readonly MenuImportQueueInterface $menuImportQueue,
    ) {}

    public function handle(RequestMenuImportCommand $command): void
    {
        $venue = $this->venues->findById($command->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $venue->workspaceId,
            userId: $command->ownerId,
        );

        $connection = $this->posConnections->findByVenueId($command->venueId);

        if ($connection === null) {
            throw new \DomainException('Точка не подключена к POS-системе');
        }

        $this->menuImportQueue->enqueue($connection->id);
    }
}
