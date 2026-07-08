<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Workspace;

use App\Application\Workspace\Entity\Membership\MembershipRoleEnum;
use App\Infrastructure\Doctrine\Domain\Workspace\MembershipRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembershipRepository::class)]
#[ORM\Table(name: 'workspace_membership')]
#[ORM\UniqueConstraint(name: 'uniq_membership_workspace_user', columns: ['workspace_id', 'user_id'])]
#[ORM\Index(name: 'idx_membership_user', columns: ['user_id'])]
class Membership
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column]
    private int $userId;

    #[ORM\Column(enumType: MembershipRoleEnum::class)]
    private MembershipRoleEnum $role;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkspaceId(): int
    {
        return $this->workspaceId;
    }

    public function setWorkspaceId(int $workspaceId): void
    {
        $this->workspaceId = $workspaceId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getRole(): MembershipRoleEnum
    {
        return $this->role;
    }

    public function setRole(MembershipRoleEnum $role): void
    {
        $this->role = $role;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
