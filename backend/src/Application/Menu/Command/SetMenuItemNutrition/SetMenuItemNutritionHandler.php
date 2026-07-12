<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\SetMenuItemNutrition;

use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use App\Application\Menu\Entity\MenuItemNutrition\MenuItemNutrition;
use App\Application\Menu\Entity\MenuItemNutrition\MenuItemNutritionRepositoryInterface;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Задаёт ручной оверрайд БЖУ товара (upsert по venueId+externalId). Менять может
 * только владелец воркспейса. Импорт из POS этот оверрайд не затрагивает.
 */
class SetMenuItemNutritionHandler
{
    public function __construct(
        private readonly MenuItemRepositoryInterface $menuItems,
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly MenuItemNutritionRepositoryInterface $nutritions,
    ) {}

    public function handle(SetMenuItemNutritionCommand $command): void
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

        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $venue->workspaceId,
            userId: $command->userId,
        );

        $override = $this->nutritions->findByVenueAndItem($item->venueId, $item->externalId);

        if ($override === null) {
            $override = MenuItemNutrition::buildNew(
                venueId: $item->venueId,
                itemExternalId: $item->externalId,
                nutrition: $command->nutrition,
            );
        } else {
            $override->change($command->nutrition);
        }

        $this->nutritions->save($override);
    }
}
