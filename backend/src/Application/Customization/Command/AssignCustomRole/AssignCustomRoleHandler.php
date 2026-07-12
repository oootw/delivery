<?php

declare(strict_types=1);

namespace App\Application\Customization\Command\AssignCustomRole;

use App\Application\Customization\Access\CustomAccess;
use App\Application\Customization\Entity\CustomRoleAssignment\CustomRoleAssignment;
use App\Application\Customization\Entity\CustomRoleAssignment\CustomRoleAssignmentRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Назначение кастомной роли участнику воркспейса владельцем. Роль должна быть объявлена
 * активным модулем, а получатель — состоять в воркспейсе. Повторное назначение идемпотентно.
 */
class AssignCustomRoleHandler
{
    public function __construct(
        private readonly CustomRoleAssignmentRepositoryInterface $assignments,
        private readonly CustomAccess $customAccess,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(AssignCustomRoleCommand $command): void
    {
        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $command->workspaceId,
            userId: $command->ownerId,
        );

        $this->customAccess->assertRoleIsAvailable($command->workspaceId, $command->roleKey);
        $this->workspaceAccess->requireMember($command->workspaceId, $command->targetUserId);

        $existing = $this->assignments->findByWorkspaceUserAndRole(
            $command->workspaceId,
            $command->targetUserId,
            $command->roleKey,
        );

        if ($existing !== null) {
            return;
        }

        $this->assignments->save(
            CustomRoleAssignment::buildNew(
                workspaceId: $command->workspaceId,
                userId: $command->targetUserId,
                roleKey: $command->roleKey,
            ),
        );
    }
}
