<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\ModifierGroup;

interface ModifierGroupRepositoryInterface
{
    public function save(ModifierGroup $group): int;

    public function findById(int $id): ?ModifierGroup;

    /**
     * @return ModifierGroup[]
     */
    public function findAllByVenue(int $venueId): array;

    /**
     * @return ModifierGroup[]
     */
    public function findActiveByVenue(int $venueId): array;
}
