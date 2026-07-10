<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Stamp;

interface StampProgressRepositoryInterface
{
    public function save(StampProgress $progress): int;

    public function findByCustomer(int $workspaceId, int $customerId): ?StampProgress;

    public function getOrCreate(int $workspaceId, int $customerId): StampProgress;
}
