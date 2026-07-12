<?php

declare(strict_types=1);

namespace App\Application\Customization\Entity\CustomRoleAssignment;

interface CustomRoleAssignmentRepositoryInterface
{
    public function save(CustomRoleAssignment $assignment): int;

    public function findByWorkspaceUserAndRole(int $workspaceId, int $userId, string $roleKey): ?CustomRoleAssignment;

    public function delete(int $assignmentId): void;

    /**
     * Ключи ролей, назначенных участнику в воркспейсе.
     *
     * @return list<string>
     */
    public function roleKeysFor(int $workspaceId, int $userId): array;
}
