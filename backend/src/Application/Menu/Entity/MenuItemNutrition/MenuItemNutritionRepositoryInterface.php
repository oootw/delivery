<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\MenuItemNutrition;

interface MenuItemNutritionRepositoryInterface
{
    public function save(MenuItemNutrition $nutrition): int;

    public function findByVenueAndItem(int $venueId, string $itemExternalId): ?MenuItemNutrition;

    /**
     * Оверрайды БЖУ точки, индексированные по externalId товара.
     *
     * @return array<string, MenuItemNutrition>
     */
    public function mapByItemExternalId(int $venueId): array;
}
