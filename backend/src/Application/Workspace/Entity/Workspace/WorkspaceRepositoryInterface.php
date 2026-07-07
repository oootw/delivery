<?php

declare(strict_types=1);

namespace App\Application\Workspace\Entity\Workspace;

interface WorkspaceRepositoryInterface
{
    public function findBySlug(string $slug): ?Workspace;

    public function create(Workspace $workspace): void;

    public function update(Workspace $workspace): void;

    public function delete(Workspace $workspace): void;

    public function findById(int $id): ?Workspace;
}
