<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\ArchiveCombo;

use App\Application\Menu\Entity\Combo\ComboRepositoryInterface;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Архивирует комбо (снимает с продажи, но не удаляет). Может только владелец воркспейса.
 */
class ArchiveComboHandler
{
    public function __construct(
        private readonly ComboRepositoryInterface $combos,
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(ArchiveComboCommand $command): void
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

        $combo->archive();

        $this->combos->save($combo);
    }
}
