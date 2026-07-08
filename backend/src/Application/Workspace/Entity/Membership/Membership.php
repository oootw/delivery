<?php

declare(strict_types=1);

namespace App\Application\Workspace\Entity\Membership;

/**
 * Участие пользователя в воркспейсе с определённой ролью.
 * Связывает пользователя и воркспейс: по членству определяется доступ.
 */
class Membership
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public int $userId,
        public MembershipRoleEnum $role,
        public \DateTimeImmutable $createdAt,
    ) {}

    public static function buildOwner(int $workspaceId, int $userId): self
    {
        return self::buildWithRole($workspaceId, $userId, MembershipRoleEnum::Owner);
    }

    public static function buildStaff(int $workspaceId, int $userId): self
    {
        return self::buildWithRole($workspaceId, $userId, MembershipRoleEnum::Staff);
    }

    public function isOwner(): bool
    {
        return $this->role === MembershipRoleEnum::Owner;
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }

    private static function buildWithRole(int $workspaceId, int $userId, MembershipRoleEnum $role): self
    {
        return new self(
            id: null,
            workspaceId: $workspaceId,
            userId: $userId,
            role: $role,
            createdAt: new \DateTimeImmutable(),
        );
    }
}
