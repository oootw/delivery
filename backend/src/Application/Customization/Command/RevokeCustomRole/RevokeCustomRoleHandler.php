<?php

declare(strict_types=1);

namespace App\Application\Customization\Command\RevokeCustomRole;

use App\Application\Customization\Entity\CustomRoleAssignment\CustomRoleAssignmentRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Снятие кастомной роли с участника воркспейса владельцем. Если назначения нет — no-op.
 */
class RevokeCustomRoleHandler
{
    public function __construct(
        private readonly CustomRoleAssignmentRepositoryInterface $assignments,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(RevokeCustomRoleCommand $command): void
    {
        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $command->workspaceId,
            userId: $command->ownerId,
        );

        $assignment = $this->assignments->findByWorkspaceUserAndRole(
            $command->workspaceId,
            $command->targetUserId,
            $command->roleKey,
        );

        if ($assignment === null || $assignment->id === null) {
            return;
        }

        $this->assignments->delete($assignment->id);
    }
}
