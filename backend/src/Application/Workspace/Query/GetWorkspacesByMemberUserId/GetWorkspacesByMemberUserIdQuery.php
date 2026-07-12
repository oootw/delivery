<?php

declare(strict_types=1);

namespace App\Application\Workspace\Query\GetWorkspacesByMemberUserId;

class GetWorkspacesByMemberUserIdQuery
{
    public function __construct(
        public readonly int $userId,
    ) {}
}
