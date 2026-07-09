<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoyaltyProgramRepository::class)]
#[ORM\Table(name: 'loyalty_program')]
#[ORM\UniqueConstraint(name: 'uniq_loyalty_program_workspace', columns: ['workspace_id'])]
class LoyaltyProgram
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
    private int $earnRateBasisPoints = 0;

    #[ORM\Column]
    private int $pointValueKopecks = 100;

    #[ORM\Column]
    private int $redeemMaxPercentBasisPoints = 5000;

    #[ORM\Column(nullable: true)]
    private ?int $pointsLifetimeDays = null;

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

    public function getEarnRateBasisPoints(): int
    {
        return $this->earnRateBasisPoints;
    }

    public function setEarnRateBasisPoints(int $earnRateBasisPoints): void
    {
        $this->earnRateBasisPoints = $earnRateBasisPoints;
    }

    public function getPointValueKopecks(): int
    {
        return $this->pointValueKopecks;
    }

    public function setPointValueKopecks(int $pointValueKopecks): void
    {
        $this->pointValueKopecks = $pointValueKopecks;
    }

    public function getRedeemMaxPercentBasisPoints(): int
    {
        return $this->redeemMaxPercentBasisPoints;
    }

    public function setRedeemMaxPercentBasisPoints(int $redeemMaxPercentBasisPoints): void
    {
        $this->redeemMaxPercentBasisPoints = $redeemMaxPercentBasisPoints;
    }

    public function getPointsLifetimeDays(): ?int
    {
        return $this->pointsLifetimeDays;
    }

    public function setPointsLifetimeDays(?int $pointsLifetimeDays): void
    {
        $this->pointsLifetimeDays = $pointsLifetimeDays;
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
