<?php

declare(strict_types=1);

namespace App\Application\Workspace\Service;

use App\Application\Workspace\Entity\Membership\MembershipRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\Workspace;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;

/**
 * Проверки доступа к воркспейсу. Владелец управляет воркспейсом и точками;
 * любой участник (владелец или сотрудник) может просматривать данные воркспейса.
 */
final class WorkspaceAccess
{
    public function __construct(
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly MembershipRepositoryInterface $memberships,
    ) {}

    public function getOwnedWorkspace(int $workspaceId, int $userId): Workspace
    {
        $workspace = $this->workspaces->findById($workspaceId);

        if ($workspace === null) {
            throw new \DomainException('Воркспейс не найден');
        }

        if ($workspace->ownerId !== $userId) {
            throw new \DomainException('Недостаточно прав');
        }

        return $workspace;
    }

    public function requireMember(int $workspaceId, int $userId): void
    {
        $membership = $this->memberships->findByWorkspaceAndUser($workspaceId, $userId);

        if ($membership === null) {
            throw new \DomainException('Нет доступа к воркспейсу');
        }
    }
}
