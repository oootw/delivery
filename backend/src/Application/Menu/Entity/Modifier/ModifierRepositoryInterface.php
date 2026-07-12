<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\Modifier;

interface ModifierRepositoryInterface
{
    public function save(Modifier $modifier): int;

    public function findById(int $id): ?Modifier;

    /**
     * @return Modifier[]
     */
    public function findAllByVenue(int $venueId): array;

    /**
     * @return Modifier[]
     */
    public function findActiveByVenue(int $venueId): array;
}
