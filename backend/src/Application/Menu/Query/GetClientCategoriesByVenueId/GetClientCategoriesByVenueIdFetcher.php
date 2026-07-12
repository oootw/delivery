<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetClientCategoriesByVenueId;

use App\Application\Menu\Client\ClientMenuAccess;
use App\Application\Menu\Entity\Category\Category;
use App\Application\Menu\Entity\Category\CategoryRepositoryInterface;
use App\Application\Menu\Image\MenuImageKind;
use App\Application\Menu\Image\MenuImageStorageInterface;

/**
 * Витрина категорий точки для клиента.
 */
class GetClientCategoriesByVenueIdFetcher
{
    public function __construct(
        private readonly ClientMenuAccess $access,
        private readonly CategoryRepositoryInterface $categories,
        private readonly MenuImageStorageInterface $menuImages,
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetch(GetClientCategoriesByVenueIdQuery $query): array
    {
        $this->access->venueOfWorkspace($query->workspaceSlug, $query->venueId);

        return array_map(
            fn(Category $category): array => [
                'id' => $category->id,
                'name' => $category->name,
                'position' => $category->position,
                'photo_url' => $this->menuImages->findUrl($query->workspaceSlug, MenuImageKind::Category, (int) $category->id),
            ],
            $this->categories->findActiveByVenue($query->venueId),
        );
    }
}
