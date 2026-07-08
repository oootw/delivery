<?php

declare(strict_types=1);

namespace App\Application\Venue\Entity\Venue;

interface VenueRepositoryInterface
{
    public function save(Venue $venue): int;

    public function findById(int $id): ?Venue;

    /**
     * @return Venue[]
     */
    public function findAllByWorkspace(int $workspaceId): array;
}
