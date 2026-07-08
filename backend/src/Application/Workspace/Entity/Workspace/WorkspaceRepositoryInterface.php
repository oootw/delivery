<?php

declare(strict_types=1);

namespace App\Application\Workspace\Entity\Workspace;

interface WorkspaceRepositoryInterface
{
    public function save(Workspace $workspace): int;

    public function findById(int $id): ?Workspace;

    public function findBySlug(string $slug): ?Workspace;

    /**
     * @param int[] $ids
     * @return Workspace[]
     */
    public function findAllByIds(array $ids): array;

    public function countByOwner(int $ownerId): int;
}
