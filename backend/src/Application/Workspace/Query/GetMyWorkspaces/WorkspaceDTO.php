<?php

declare(strict_types=1);

namespace App\Application\Workspace\Query\GetMyWorkspaces;

class WorkspaceDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $description,
        public readonly string $role,
    ) {}
}
