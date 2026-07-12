<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\DeleteMenuImage;

use App\Application\Menu\Image\MenuImageEntityLocator;
use App\Application\Menu\Image\MenuImageStorageInterface;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Удаляет фото сущности меню. Удалять может только владелец воркспейса.
 */
class DeleteMenuImageHandler
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly MenuImageEntityLocator $entityLocator,
        private readonly MenuImageStorageInterface $menuImages,
    ) {}

    public function handle(DeleteMenuImageCommand $command): void
    {
        $venue = $this->venues->findById($command->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $workspace = $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $venue->workspaceId,
            userId: $command->userId,
        );

        $entityVenueId = $this->entityLocator->venueIdOf($command->kind, $command->entityId);

        if ($entityVenueId === null) {
            throw new \DomainException('Сущность меню не найдена');
        }

        if ($entityVenueId !== $venue->id) {
            throw new \DomainException('Сущность меню не относится к этой точке');
        }

        $this->menuImages->delete(
            slug: $workspace->slug,
            kind: $command->kind,
            id: $command->entityId,
        );
    }
}
