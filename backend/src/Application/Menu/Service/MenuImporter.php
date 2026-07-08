<?php

declare(strict_types=1);

namespace App\Application\Menu\Service;

use App\Application\Menu\Entity\Category\Category;
use App\Application\Menu\Entity\Category\CategoryRepositoryInterface;
use App\Application\Menu\Entity\MenuItem\MenuItem;
use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use App\Application\Menu\Entity\Modifier\Modifier;
use App\Application\Menu\Entity\Modifier\ModifierRepositoryInterface;
use App\Application\Menu\Entity\ModifierGroup\ModifierGroup;
use App\Application\Menu\Entity\ModifierGroup\ModifierGroupRepositoryInterface;
use App\Application\PosIntegration\Gateway\PosMenuSnapshot;

/**
 * Приводит меню точки в соответствие снимку из POS: обновляет и создаёт записи
 * по externalId, а всё, чего в снимке нет, помечает архивным (не удаляет).
 */
final class MenuImporter
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categories,
        private readonly MenuItemRepositoryInterface $items,
        private readonly ModifierGroupRepositoryInterface $modifierGroups,
        private readonly ModifierRepositoryInterface $modifiers,
    ) {}

    public function import(int $venueId, PosMenuSnapshot $snapshot): void
    {
        $this->importCategories($venueId, $snapshot);
        $this->importItems($venueId, $snapshot);
        $this->importModifierGroups($venueId, $snapshot);
        $this->importModifiers($venueId, $snapshot);
    }

    private function importCategories(int $venueId, PosMenuSnapshot $snapshot): void
    {
        $existing = $this->mapByExternalId($this->categories->findAllByVenue($venueId));
        $seen = [];

        foreach ($snapshot->categories as $posCategory) {
            $category = $existing[$posCategory->externalId] ?? null;

            if ($category === null) {
                $category = Category::buildNew(
                    venueId: $venueId,
                    externalId: $posCategory->externalId,
                    name: $posCategory->name,
                    position: $posCategory->position,
                );
            } else {
                $category->applyFromPos(name: $posCategory->name, position: $posCategory->position);
            }

            $this->categories->save($category);
            $seen[$posCategory->externalId] = true;
        }

        foreach ($existing as $externalId => $category) {
            if (!isset($seen[$externalId]) && !$category->isArchived) {
                $category->archive();
                $this->categories->save($category);
            }
        }
    }

    private function importItems(int $venueId, PosMenuSnapshot $snapshot): void
    {
        $existing = $this->mapByExternalId($this->items->findAllByVenue($venueId));
        $seen = [];

        foreach ($snapshot->categories as $posCategory) {
            foreach ($posCategory->items as $posItem) {
                $item = $existing[$posItem->externalId] ?? null;

                if ($item === null) {
                    $item = MenuItem::buildNew(
                        venueId: $venueId,
                        externalId: $posItem->externalId,
                        categoryExternalId: $posItem->categoryExternalId,
                        name: $posItem->name,
                        description: $posItem->description,
                        priceKopecks: $posItem->priceKopecks,
                        imageUrl: $posItem->imageUrl,
                        isAvailable: $posItem->isAvailable,
                        position: $posItem->position,
                        modifierGroupExternalIds: $posItem->modifierGroupExternalIds,
                    );
                } else {
                    $item->applyFromPos(
                        categoryExternalId: $posItem->categoryExternalId,
                        name: $posItem->name,
                        description: $posItem->description,
                        priceKopecks: $posItem->priceKopecks,
                        imageUrl: $posItem->imageUrl,
                        isAvailable: $posItem->isAvailable,
                        position: $posItem->position,
                        modifierGroupExternalIds: $posItem->modifierGroupExternalIds,
                    );
                }

                $this->items->save($item);
                $seen[$posItem->externalId] = true;
            }
        }

        foreach ($existing as $externalId => $item) {
            if (!isset($seen[$externalId]) && !$item->isArchived) {
                $item->archive();
                $this->items->save($item);
            }
        }
    }

    private function importModifierGroups(int $venueId, PosMenuSnapshot $snapshot): void
    {
        $existing = $this->mapByExternalId($this->modifierGroups->findAllByVenue($venueId));
        $seen = [];

        foreach ($snapshot->modifierGroups as $posGroup) {
            $group = $existing[$posGroup->externalId] ?? null;

            if ($group === null) {
                $group = ModifierGroup::buildNew(
                    venueId: $venueId,
                    externalId: $posGroup->externalId,
                    name: $posGroup->name,
                    minSelection: $posGroup->minSelection,
                    maxSelection: $posGroup->maxSelection,
                );
            } else {
                $group->applyFromPos(
                    name: $posGroup->name,
                    minSelection: $posGroup->minSelection,
                    maxSelection: $posGroup->maxSelection,
                );
            }

            $this->modifierGroups->save($group);
            $seen[$posGroup->externalId] = true;
        }

        foreach ($existing as $externalId => $group) {
            if (!isset($seen[$externalId]) && !$group->isArchived) {
                $group->archive();
                $this->modifierGroups->save($group);
            }
        }
    }

    private function importModifiers(int $venueId, PosMenuSnapshot $snapshot): void
    {
        $existing = $this->mapByExternalId($this->modifiers->findAllByVenue($venueId));
        $seen = [];

        foreach ($snapshot->modifierGroups as $posGroup) {
            foreach ($posGroup->modifiers as $posModifier) {
                $modifier = $existing[$posModifier->externalId] ?? null;

                if ($modifier === null) {
                    $modifier = Modifier::buildNew(
                        venueId: $venueId,
                        externalId: $posModifier->externalId,
                        modifierGroupExternalId: $posGroup->externalId,
                        name: $posModifier->name,
                        priceKopecks: $posModifier->priceKopecks,
                    );
                } else {
                    $modifier->applyFromPos(
                        modifierGroupExternalId: $posGroup->externalId,
                        name: $posModifier->name,
                        priceKopecks: $posModifier->priceKopecks,
                    );
                }

                $this->modifiers->save($modifier);
                $seen[$posModifier->externalId] = true;
            }
        }

        foreach ($existing as $externalId => $modifier) {
            if (!isset($seen[$externalId]) && !$modifier->isArchived) {
                $modifier->archive();
                $this->modifiers->save($modifier);
            }
        }
    }

    /**
     * @template T of object
     * @param T[] $records
     * @return array<string, T>
     */
    private function mapByExternalId(array $records): array
    {
        $map = [];

        foreach ($records as $record) {
            $map[$record->externalId] = $record;
        }

        return $map;
    }
}
