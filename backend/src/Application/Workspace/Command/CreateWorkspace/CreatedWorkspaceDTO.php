<?php

declare(strict_types=1);

namespace App\Application\Workspace\Command\CreateWorkspace;

class CreatedWorkspaceDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $slug,
    ) {}
}
