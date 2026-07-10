<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StampProgramRepository::class)]
#[ORM\Table(name: 'stamp_program')]
#[ORM\UniqueConstraint(name: 'uniq_stamp_program_workspace', columns: ['workspace_id'])]
class StampProgram
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column]
    private bool $isEnabled = false;

    #[ORM\Column]
    private int $requiredCount;

    #[ORM\Column]
    private int $rewardPoints;

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

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): void
    {
        $this->isEnabled = $isEnabled;
    }

    public function getRequiredCount(): int
    {
        return $this->requiredCount;
    }

    public function setRequiredCount(int $requiredCount): void
    {
        $this->requiredCount = $requiredCount;
    }

    public function getRewardPoints(): int
    {
        return $this->rewardPoints;
    }

    public function setRewardPoints(int $rewardPoints): void
    {
        $this->rewardPoints = $rewardPoints;
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
