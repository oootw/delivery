<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetClientProductById;

use App\Application\Menu\Client\ClientMenuAccess;
use App\Application\Menu\Client\ClientProductAssembler;
use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use App\Application\Menu\Entity\MenuItemNutrition\MenuItemNutritionRepositoryInterface;
use App\Application\Menu\Entity\Modifier\Modifier;
use App\Application\Menu\Entity\Modifier\ModifierRepositoryInterface;
use App\Application\Menu\Entity\ModifierGroup\ModifierGroup;
use App\Application\Menu\Entity\ModifierGroup\ModifierGroupRepositoryInterface;

/**
 * Деталка товара для клиента: изображения, описание, характеристики (БЖУ на 100 г и на
 * порцию) и модификаторы. Тип отображения группы (radio/checkbox) выводится из max_selection.
 */
class GetClientProductByIdFetcher
{
    public function __construct(
        private readonly ClientMenuAccess $access,
        private readonly MenuItemRepositoryInterface $items,
        private readonly MenuItemNutritionRepositoryInterface $nutritions,
        private readonly ModifierGroupRepositoryInterface $modifierGroups,
        private readonly ModifierRepositoryInterface $modifiers,
        private readonly ClientProductAssembler $assembler,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function fetch(GetClientProductByIdQuery $query): array
    {
        $workspace = $this->access->workspaceById($query->workspaceId);
        $this->access->venueOfWorkspace($query->workspaceId, $query->venueId);

        $item = $this->items->findById($query->itemId);

        if ($item === null || $item->venueId !== $query->venueId || $item->isArchived) {
            throw new \DomainException('Позиция меню не найдена');
        }

        $override = $this->nutritions->findByVenueAndItem($query->venueId, $item->externalId);
        $nutrition = $this->assembler->effectiveNutrition($item, $override);

        return [
            'id' => $item->id,
            'external_id' => $item->externalId,
            'name' => $item->name,
            'description' => $item->description,
            'price_kopecks' => $item->priceKopecks,
            'is_available' => $item->isAvailable,
            'images' => $this->assembler->images($workspace->slug, $item),
            'nutrition' => $nutrition->toArray(),
            'modifier_groups' => $this->buildModifierGroups($item->modifierGroupExternalIds, $query->venueId),
        ];
    }

    /**
     * @param string[] $groupExternalIds
     * @return array<int, array<string, mixed>>
     */
    private function buildModifierGroups(array $groupExternalIds, int $venueId): array
    {
        $groups = $this->indexModifierGroups($venueId);
        $modifiersByGroup = $this->groupModifiersByGroup($venueId);

        $result = [];

        foreach ($groupExternalIds as $groupExternalId) {
            $group = $groups[$groupExternalId] ?? null;

            if ($group === null) {
                continue;
            }

            $result[] = [
                'id' => $group->id,
                'external_id' => $group->externalId,
                'name' => $group->name,
                'display_type' => $group->maxSelection === 1 ? 'radio' : 'checkbox',
                'min_selection' => $group->minSelection,
                'max_selection' => $group->maxSelection,
                'modifiers' => array_map(
                    static fn(Modifier $modifier): array => [
                        'id' => $modifier->id,
                        'external_id' => $modifier->externalId,
                        'name' => $modifier->name,
                        'price_kopecks' => $modifier->priceKopecks,
                    ],
                    $modifiersByGroup[$group->externalId] ?? [],
                ),
            ];
        }

        return $result;
    }

    /**
     * @return array<string, ModifierGroup>
     */
    private function indexModifierGroups(int $venueId): array
    {
        $indexed = [];

        foreach ($this->modifierGroups->findActiveByVenue($venueId) as $group) {
            $indexed[$group->externalId] = $group;
        }

        return $indexed;
    }

    /**
     * @return array<string, Modifier[]>
     */
    private function groupModifiersByGroup(int $venueId): array
    {
        $grouped = [];

        foreach ($this->modifiers->findActiveByVenue($venueId) as $modifier) {
            $grouped[$modifier->modifierGroupExternalId][] = $modifier;
        }

        return $grouped;
    }
}
