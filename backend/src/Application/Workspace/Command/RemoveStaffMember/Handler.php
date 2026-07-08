<?php

declare(strict_types=1);

namespace App\Application\Workspace\Command\RemoveStaffMember;

use App\Application\Workspace\Entity\Membership\MembershipRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;

class Handler
{
    public function __construct(
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly MembershipRepositoryInterface $memberships,
    ) {}

    public function handle(Command $command): void
    {
        $workspace = $this->workspaces->findById($command->workspaceId);

        if ($workspace === null) {
            throw new \DomainException('Воркспейс не найден');
        }

        if ($workspace->ownerId !== $command->ownerId) {
            throw new \DomainException('Недостаточно прав');
        }

        $membership = $this->memberships->findByWorkspaceAndUser(
            workspaceId: $command->workspaceId,
            userId: $command->staffUserId,
        );

        if ($membership === null) {
            throw new \DomainException('Сотрудник не найден в воркспейсе');
        }

        if ($membership->isOwner()) {
            throw new \DomainException('Нельзя удалить владельца воркспейса');
        }

        $this->memberships->delete($membership->id);
    }
}
