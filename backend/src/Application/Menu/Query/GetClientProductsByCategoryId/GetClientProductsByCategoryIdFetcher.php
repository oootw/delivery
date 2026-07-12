<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetClientProductsByCategoryId;

use App\Application\Menu\Client\ClientMenuAccess;
use App\Application\Menu\Client\ClientProductAssembler;
use App\Application\Menu\Entity\Category\CategoryRepositoryInterface;
use App\Application\Menu\Entity\MenuItem\MenuItem;
use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use App\Application\Menu\Entity\MenuItemNutrition\MenuItemNutritionRepositoryInterface;

/**
 * Витрина товаров категории для клиента: карточки с фото, ценой, названием и двумя
 * характеристиками (граммовка и калории). old_price_kopecks зарезервирован под пер-товарные
 * скидки (пока их нет в модели — всегда null).
 */
class GetClientProductsByCategoryIdFetcher
{
    public function __construct(
        private readonly ClientMenuAccess $access,
        private readonly CategoryRepositoryInterface $categories,
        private readonly MenuItemRepositoryInterface $items,
        private readonly MenuItemNutritionRepositoryInterface $nutritions,
        private readonly ClientProductAssembler $assembler,
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetch(GetClientProductsByCategoryIdQuery $query): array
    {
        $this->access->venueOfWorkspace($query->workspaceSlug, $query->venueId);

        $category = $this->categories->findById($query->categoryId);

        if ($category === null || $category->venueId !== $query->venueId) {
            throw new \DomainException('Категория не найдена');
        }

        $overrides = $this->nutritions->mapByItemExternalId($query->venueId);

        $cards = [];

        foreach ($this->items->findActiveByVenue($query->venueId) as $item) {
            if ($item->categoryExternalId !== $category->externalId || !$item->isAvailable) {
                continue;
            }

            $cards[] = $this->cardFor($item, $query->workspaceSlug, $overrides);
        }

        return $cards;
    }

    /**
     * @param array<string, \App\Application\Menu\Entity\MenuItemNutrition\MenuItemNutrition> $overrides
     * @return array<string, mixed>
     */
    private function cardFor(MenuItem $item, string $slug, array $overrides): array
    {
        $nutrition = $this->assembler->effectiveNutrition($item, $overrides[$item->externalId] ?? null);
        $images = $this->assembler->images($slug, $item);

        return [
            'id' => $item->id,
            'external_id' => $item->externalId,
            'name' => $item->name,
            'image_url' => $images[0] ?? null,
            'price_kopecks' => $item->priceKopecks,
            'old_price_kopecks' => null,
            'weight_g' => $nutrition->weightGrams,
            'kcal' => $this->assembler->displayKcal($nutrition),
        ];
    }
}
