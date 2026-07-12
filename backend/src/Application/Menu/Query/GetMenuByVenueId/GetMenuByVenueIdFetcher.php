<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetMenuByVenueId;

use App\Application\Menu\Entity\Category\Category;
use App\Application\Menu\Entity\Category\CategoryRepositoryInterface;
use App\Application\Menu\Entity\Combo\Combo;
use App\Application\Menu\Entity\Combo\ComboRepositoryInterface;
use App\Application\Menu\Entity\MenuItem\MenuItem;
use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use App\Application\Menu\Entity\Modifier\Modifier;
use App\Application\Menu\Entity\Modifier\ModifierRepositoryInterface;
use App\Application\Menu\Entity\ModifierGroup\ModifierGroup;
use App\Application\Menu\Entity\ModifierGroup\ModifierGroupRepositoryInterface;
use App\Application\Menu\Image\MenuImageKind;
use App\Application\Menu\Image\MenuImageStorageInterface;
use App\Application\Menu\Service\ComboPricing;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

class GetMenuByVenueIdFetcher
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly CategoryRepositoryInterface $categories,
        private readonly MenuItemRepositoryInterface $items,
        private readonly ModifierGroupRepositoryInterface $modifierGroups,
        private readonly ModifierRepositoryInterface $modifiers,
        private readonly ComboRepositoryInterface $combos,
        private readonly ComboPricing $comboPricing,
        private readonly MenuImageStorageInterface $menuImages,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function fetch(GetMenuByVenueIdQuery $query): array
    {
        $venue = $this->venues->findById($query->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $this->workspaceAccess->requireMember(
            workspaceId: $venue->workspaceId,
            userId: $query->userId,
        );

        $workspace = $this->workspaces->findById($venue->workspaceId);

        if ($workspace === null) {
            throw new \DomainException('Воркспейс точки не найден');
        }

        $slug = $workspace->slug;
        $itemsByCategory = $this->groupItemsByCategory($query->venueId);
        $itemsByExternalId = $this->indexItemsByExternalId($query->venueId);
        $modifierGroups = $this->indexModifierGroups($query->venueId);
        $modifiersByGroup = $this->groupModifiersByGroup($query->venueId);

        $categories = array_map(
            fn(Category $category): array => [
                'id' => $category->id,
                'external_id' => $category->externalId,
                'name' => $category->name,
                'position' => $category->position,
                'photo_url' => $this->menuImages->findUrl($slug, MenuImageKind::Category, (int) $category->id),
                'items' => array_map(
                    fn(MenuItem $item): array => $this->itemToArray($item, $slug, $modifierGroups, $modifiersByGroup),
                    $itemsByCategory[$category->externalId] ?? [],
                ),
            ],
            $this->categories->findActiveByVenue($query->venueId),
        );

        $combos = array_map(
            fn(Combo $combo): array => $this->comboToArray($combo, $slug, $itemsByExternalId),
            $this->combos->findActiveByVenue($query->venueId),
        );

        return [
            'categories' => $categories,
            'combos' => $combos,
        ];
    }

    /**
     * @param array<string, ModifierGroup> $modifierGroups
     * @param array<string, Modifier[]> $modifiersByGroup
     * @return array<string, mixed>
     */
    private function itemToArray(MenuItem $item, string $slug, array $modifierGroups, array $modifiersByGroup): array
    {
        $gallery = $this->menuImages->findItemGallery($slug, (int) $item->id);
        $firstGalleryUrl = $gallery === [] ? null : $gallery[array_key_first($gallery)];

        // POS-картинка приоритетнее галереи; галерея — запасной вариант.
        $imageUrl = $item->imageUrl ?? $firstGalleryUrl;

        return [
            'id' => $item->id,
            'external_id' => $item->externalId,
            'name' => $item->name,
            'description' => $item->description,
            'price_kopecks' => $item->priceKopecks,
            'image_url' => $imageUrl,
            'photos' => $this->galleryToArray($gallery),
            'is_available' => $item->isAvailable,
            'position' => $item->position,
            'modifier_groups' => $this->buildModifierGroups(
                $item->modifierGroupExternalIds,
                $slug,
                $modifierGroups,
                $modifiersByGroup,
            ),
        ];
    }

    /**
     * @param array<int, string> $gallery index => url
     * @return array<int, array{index: int, url: string}>
     */
    private function galleryToArray(array $gallery): array
    {
        $photos = [];

        foreach ($gallery as $index => $url) {
            $photos[] = ['index' => $index, 'url' => $url];
        }

        return $photos;
    }

    /**
     * @param array<string, MenuItem> $itemsByExternalId
     * @return array<string, mixed>
     */
    private function comboToArray(Combo $combo, string $slug, array $itemsByExternalId): array
    {
        $price = $this->comboPricing->price($combo, $itemsByExternalId);

        return [
            'id' => $combo->id,
            'external_id' => $combo->externalId,
            'name' => $combo->name,
            'description' => $combo->description,
            'discount_type' => $combo->discountType->value,
            'discount_value' => $combo->discountValue,
            'subtotal_kopecks' => $price->subtotalKopecks,
            'discount_kopecks' => $price->discountKopecks,
            'price_kopecks' => $price->priceKopecks,
            'is_available' => $price->isAvailable,
            'position' => $combo->position,
            'photo_url' => $this->menuImages->findUrl($slug, MenuImageKind::Combo, (int) $combo->id),
            'items' => array_map(
                function ($comboItem) use ($itemsByExternalId): array {
                    $menuItem = $itemsByExternalId[$comboItem->itemExternalId] ?? null;

                    return [
                        'item_external_id' => $comboItem->itemExternalId,
                        'name' => $menuItem?->name,
                        'quantity' => $comboItem->quantity,
                        'price_kopecks' => $menuItem?->priceKopecks,
                    ];
                },
                $combo->items,
            ),
        ];
    }

    /**
     * @param string[] $groupExternalIds
     * @param array<string, ModifierGroup> $modifierGroups
     * @param array<string, Modifier[]> $modifiersByGroup
     * @return array<int, array<string, mixed>>
     */
    private function buildModifierGroups(array $groupExternalIds, string $slug, array $modifierGroups, array $modifiersByGroup): array
    {
        $result = [];

        foreach ($groupExternalIds as $groupExternalId) {
            $group = $modifierGroups[$groupExternalId] ?? null;

            if ($group === null) {
                continue;
            }

            $result[] = [
                'id' => $group->id,
                'external_id' => $group->externalId,
                'name' => $group->name,
                'min_selection' => $group->minSelection,
                'max_selection' => $group->maxSelection,
                'photo_url' => $this->menuImages->findUrl($slug, MenuImageKind::ModifierGroup, (int) $group->id),
                'modifiers' => array_map(
                    fn(Modifier $modifier): array => [
                        'id' => $modifier->id,
                        'external_id' => $modifier->externalId,
                        'name' => $modifier->name,
                        'price_kopecks' => $modifier->priceKopecks,
                        'photo_url' => $this->menuImages->findUrl($slug, MenuImageKind::Modifier, (int) $modifier->id),
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
     * @return array<string, MenuItem>
     */
    private function indexItemsByExternalId(int $venueId): array
    {
        $indexed = [];

        foreach ($this->items->findActiveByVenue($venueId) as $item) {
            $indexed[$item->externalId] = $item;
        }

        return $indexed;
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
