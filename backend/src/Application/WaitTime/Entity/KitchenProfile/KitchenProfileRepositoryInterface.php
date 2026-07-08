<?php

declare(strict_types=1);

namespace App\Application\WaitTime\Entity\KitchenProfile;

interface KitchenProfileRepositoryInterface
{
    public function save(KitchenProfile $profile): int;

    public function findByVenue(int $venueId): ?KitchenProfile;
}
