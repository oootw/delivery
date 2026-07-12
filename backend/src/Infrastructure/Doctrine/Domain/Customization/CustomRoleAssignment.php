<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Customization;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomRoleAssignmentRepository::class)]
#[ORM\Table(name: 'custom_role_assignment')]
#[ORM\UniqueConstraint(name: 'uniq_custom_role_assignment', columns: ['workspace_id', 'user_id', 'role_key'])]
class CustomRoleAssignment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column]
    private int $userId;

    #[ORM\Column(length: 64)]
    private string $roleKey;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

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

    public function getRoleKey(): string
    {
        return $this->roleKey;
    }

    public function setRoleKey(string $roleKey): void
    {
        $this->roleKey = $roleKey;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
