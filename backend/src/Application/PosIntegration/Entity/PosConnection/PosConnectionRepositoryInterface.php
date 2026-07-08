<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Entity\PosConnection;

interface PosConnectionRepositoryInterface
{
    public function save(PosConnection $connection): int;

    public function findById(int $id): ?PosConnection;

    public function findByVenue(int $venueId): ?PosConnection;
}
