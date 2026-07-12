<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\UploadMenuImage;

use App\Application\Menu\Image\MenuImageEntityLocator;
use App\Application\Menu\Image\MenuImageStorageInterface;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Загружает фото сущности меню (товар/категория/модификатор/группа/комбо). Загружать
 * может только владелец воркспейса; файл кладётся в каталог воркспейса и заменяет прежнее фото.
 */
class UploadMenuImageHandler
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly MenuImageEntityLocator $entityLocator,
        private readonly MenuImageStorageInterface $menuImages,
    ) {}

    public function handle(UploadMenuImageCommand $command): string
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

        return $this->menuImages->store(
            slug: $workspace->slug,
            kind: $command->kind,
            id: $command->entityId,
            sourcePath: $command->sourcePath,
            extension: $command->extension,
        );
    }
}
