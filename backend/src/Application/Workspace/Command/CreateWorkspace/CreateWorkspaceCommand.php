<?php

declare(strict_types=1);

namespace App\Application\Workspace\Command\CreateWorkspace;

class CreateWorkspaceCommand
{
    public function __construct(
        public readonly int $ownerId,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $description,
    ) {}
}
