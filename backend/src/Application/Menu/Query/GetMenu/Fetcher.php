<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetMenu;

use App\Application\Menu\Entity\Category\Category;
use App\Application\Menu\Entity\Category\CategoryRepositoryInterface;
use App\Application\Menu\Entity\MenuItem\MenuItem;
use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use App\Application\Menu\Entity\Modifier\Modifier;
use App\Application\Menu\Entity\Modifier\ModifierRepositoryInterface;
use App\Application\Menu\Entity\ModifierGroup\ModifierGroup;
use App\Application\Menu\Entity\ModifierGroup\ModifierGroupRepositoryInterface;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

class Fetcher
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly CategoryRepositoryInterface $categories,
        private readonly MenuItemRepositoryInterface $items,
        private readonly ModifierGroupRepositoryInterface $modifierGroups,
        private readonly ModifierRepositoryInterface $modifiers,
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetch(Query $query): array
    {
        $venue = $this->venues->findById($query->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $this->workspaceAccess->requireMember(
            workspaceId: $venue->workspaceId,
            userId: $query->userId,
        );

        $itemsByCategory = $this->groupItemsByCategory($query->venueId);
        $modifierGroups = $this->indexModifierGroups($query->venueId);
        $modifiersByGroup = $this->groupModifiersByGroup($query->venueId);

        return array_map(
            fn(Category $category): array => [
                'external_id' => $category->externalId,
                'name' => $category->name,
                'position' => $category->position,
                'items' => array_map(
                    fn(MenuItem $item): array => $this->itemToArray($item, $modifierGroups, $modifiersByGroup),
                    $itemsByCategory[$category->externalId] ?? [],
                ),
            ],
            $this->categories->findActiveByVenue($query->venueId),
        );
    }

    /**
     * @param array<string, ModifierGroup> $modifierGroups
     * @param array<string, Modifier[]> $modifiersByGroup
     * @return array<string, mixed>
     */
    private function itemToArray(MenuItem $item, array $modifierGroups, array $modifiersByGroup): array
    {
        return [
            'external_id' => $item->externalId,
            'name' => $item->name,
            'description' => $item->description,
            'price_kopecks' => $item->priceKopecks,
            'image_url' => $item->imageUrl,
            'is_available' => $item->isAvailable,
            'position' => $item->position,
            'modifier_groups' => $this->resolveModifierGroups(
                $item->modifierGroupExternalIds,
                $modifierGroups,
                $modifiersByGroup,
            ),
        ];
    }

    /**
     * @param string[] $groupExternalIds
     * @param array<string, ModifierGroup> $modifierGroups
     * @param array<string, Modifier[]> $modifiersByGroup
     * @return array<int, array<string, mixed>>
     */
    private function resolveModifierGroups(array $groupExternalIds, array $modifierGroups, array $modifiersByGroup): array
    {
        $result = [];

        foreach ($groupExternalIds as $groupExternalId) {
            $group = $modifierGroups[$groupExternalId] ?? null;

            if ($group === null) {
                continue;
            }

            $result[] = [
                'external_id' => $group->externalId,
                'name' => $group->name,
                'min_selection' => $group->minSelection,
                'max_selection' => $group->maxSelection,
                'modifiers' => array_map(
                    fn(Modifier $modifier): array => [
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
     * @return array<string, MenuItem[]>
     */
    private function groupItemsByCategory(int $venueId): array
    {
        $grouped = [];

        foreach ($this->items->findActiveByVenue($venueId) as $item) {
            $grouped[$item->categoryExternalId][] = $item;
        }

        return $grouped;
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
