<?php

declare(strict_types=1);

namespace App\Application\Workspace\Command\RemoveStaffMember;

class Command
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly int $staffUserId,
    ) {}
}
