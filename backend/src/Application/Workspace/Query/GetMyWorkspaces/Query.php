<?php

declare(strict_types=1);

namespace App\Application\Workspace\Query\GetMyWorkspaces;

class Query
{
    public function __construct(
        public readonly int $userId,
    ) {}
}
