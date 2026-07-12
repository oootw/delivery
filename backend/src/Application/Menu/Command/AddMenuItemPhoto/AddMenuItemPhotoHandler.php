<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\AddMenuItemPhoto;

use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use App\Application\Menu\Image\MenuImageStorageInterface;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Добавляет фото в галерею товара (первый свободный слот). Загружать может только
 * владелец воркспейса. Возвращает индекс слота и публичный URL.
 */
class AddMenuItemPhotoHandler
{
    public function __construct(
        private readonly MenuItemRepositoryInterface $menuItems,
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly MenuImageStorageInterface $menuImages,
    ) {}

    /**
     * @return array{index: int, url: string}
     */
    public function handle(AddMenuItemPhotoCommand $command): array
    {
        $item = $this->menuItems->findById($command->itemId);

        if ($item === null) {
            throw new \DomainException('Позиция меню не найдена');
        }

        if ($item->venueId !== $command->venueId) {
            throw new \DomainException('Позиция не относится к этой точке');
        }

        $venue = $this->venues->findById($item->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $workspace = $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $venue->workspaceId,
            userId: $command->userId,
        );

        return $this->menuImages->addToItemGallery(
            slug: $workspace->slug,
            itemId: $item->id,
            sourcePath: $command->sourcePath,
            extension: $command->extension,
        );
    }
}
