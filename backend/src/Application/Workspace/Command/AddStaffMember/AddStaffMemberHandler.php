<?php

declare(strict_types=1);

namespace App\Application\Workspace\Command\AddStaffMember;

use App\Application\Authorize\Entity\User\UserRepositoryInterface;
use App\Application\Workspace\Entity\Membership\Membership;
use App\Application\Workspace\Entity\Membership\MembershipRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;

class AddStaffMemberHandler
{
    public function __construct(
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly MembershipRepositoryInterface $memberships,
        private readonly UserRepositoryInterface $users,
    ) {}

    public function handle(AddStaffMemberCommand $command): void
    {
        $workspace = $this->workspaces->findById($command->workspaceId);

        if ($workspace === null) {
            throw new \DomainException('Воркспейс не найден');
        }

        if ($workspace->ownerId !== $command->ownerId) {
            throw new \DomainException('Недостаточно прав');
        }

        $staffUser = $this->users->findByPhone($command->staffPhone);

        if ($staffUser === null) {
            throw new \DomainException('Пользователь с таким телефоном не зарегистрирован');
        }

        $existingMembership = $this->memberships->findByWorkspaceAndUser(
            workspaceId: $command->workspaceId,
            userId: $staffUser->id,
        );

        if ($existingMembership !== null) {
            throw new \DomainException('Пользователь уже состоит в воркспейсе');
        }

        $this->memberships->save(
            Membership::buildStaff(
                workspaceId: $command->workspaceId,
                userId: $staffUser->id,
            ),
        );
    }
}
