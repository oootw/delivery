<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\MenuItem;

interface MenuItemRepositoryInterface
{
    public function save(MenuItem $item): int;

    /**
     * @return MenuItem[]
     */
    public function findAllByVenue(int $venueId): array;

    /**
     * @return MenuItem[]
     */
    public function findActiveByVenue(int $venueId): array;

    public function findById(int $id): ?MenuItem;
}
