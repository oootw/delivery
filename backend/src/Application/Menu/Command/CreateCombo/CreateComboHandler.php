<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\CreateCombo;

use App\Application\Menu\Entity\Combo\Combo;
use App\Application\Menu\Entity\Combo\ComboRepositoryInterface;
use App\Application\Menu\Service\ComboItemsGuard;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;
use Symfony\Component\Uid\Uuid;

/**
 * Создаёт комбо точки. Создавать может только владелец воркспейса; товары состава
 * должны быть в актуальном меню. externalId генерируется (задел на импорт из POS).
 */
class CreateComboHandler
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly ComboItemsGuard $comboItemsGuard,
        private readonly ComboRepositoryInterface $combos,
    ) {}

    public function handle(CreateComboCommand $command): int
    {
        $venue = $this->venues->findById($command->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $venue->workspaceId,
            userId: $command->userId,
        );

        $this->comboItemsGuard->assertItemsExist($venue->id, $command->items);

        $combo = Combo::buildNew(
            venueId: $venue->id,
            externalId: Uuid::v4()->toRfc4122(),
            name: $command->name,
            description: $command->description,
            discountType: $command->discountType,
            discountValue: $command->discountValue,
            items: $command->items,
            position: $command->position,
            isAvailable: $command->isAvailable,
        );

        return $this->combos->save($combo);
    }
}
