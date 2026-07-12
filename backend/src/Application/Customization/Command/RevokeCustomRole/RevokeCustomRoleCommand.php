<?php

declare(strict_types=1);

namespace App\Application\Customization\Command\RevokeCustomRole;

class RevokeCustomRoleCommand
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly int $targetUserId,
        public readonly string $roleKey,
    ) {}
}
