<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\DeleteMenuItemPhoto;

use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use App\Application\Menu\Image\MenuImageStorageInterface;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Удаляет фото из галереи товара по индексу слота. Может только владелец воркспейса.
 */
class DeleteMenuItemPhotoHandler
{
    public function __construct(
        private readonly MenuItemRepositoryInterface $menuItems,
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly MenuImageStorageInterface $menuImages,
    ) {}

    public function handle(DeleteMenuItemPhotoCommand $command): void
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

        $this->menuImages->deleteItemGalleryIndex(
            slug: $workspace->slug,
            itemId: $item->id,
            index: $command->index,
        );
    }
}
