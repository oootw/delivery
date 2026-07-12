<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\UpdateCombo;

use App\Application\Menu\Entity\Combo\ComboRepositoryInterface;
use App\Application\Menu\Service\ComboItemsGuard;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Полностью обновляет комбо. Менять может только владелец воркспейса; товары состава
 * должны быть в актуальном меню точки.
 */
class UpdateComboHandler
{
    public function __construct(
        private readonly ComboRepositoryInterface $combos,
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly ComboItemsGuard $comboItemsGuard,
    ) {}

    public function handle(UpdateComboCommand $command): void
    {
        $combo = $this->combos->findById($command->comboId);

        if ($combo === null) {
            throw new \DomainException('Комбо не найдено');
        }

        $venue = $this->venues->findById($combo->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $venue->workspaceId,
            userId: $command->userId,
        );

        $this->comboItemsGuard->assertItemsExist($combo->venueId, $command->items);

        $combo->update(
            name: $command->name,
            description: $command->description,
            discountType: $command->discountType,
            discountValue: $command->discountValue,
            items: $command->items,
            position: $command->position,
            isAvailable: $command->isAvailable,
        );

        $this->combos->save($combo);
    }
}
