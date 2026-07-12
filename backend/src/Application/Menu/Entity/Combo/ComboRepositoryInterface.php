<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\Combo;

interface ComboRepositoryInterface
{
    public function save(Combo $combo): int;

    public function findById(int $id): ?Combo;

    public function findByVenueAndExternalId(int $venueId, string $externalId): ?Combo;

    /**
     * @return Combo[]
     */
    public function findAllByVenue(int $venueId): array;

    /**
     * @return Combo[]
     */
    public function findActiveByVenue(int $venueId): array;
}
