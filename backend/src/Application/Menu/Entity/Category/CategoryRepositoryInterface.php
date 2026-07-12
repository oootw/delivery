<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\Category;

interface CategoryRepositoryInterface
{
    public function save(Category $category): int;

    public function findById(int $id): ?Category;

    /**
     * @return Category[]
     */
    public function findAllByVenue(int $venueId): array;

    /**
     * @return Category[]
     */
    public function findActiveByVenue(int $venueId): array;
}
