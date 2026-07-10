<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoyaltyTierRepository::class)]
#[ORM\Table(name: 'loyalty_tier')]
#[ORM\Index(name: 'idx_loyalty_tier_workspace', columns: ['workspace_id'])]
class LoyaltyTier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private int $thresholdKopecks;

    #[ORM\Column]
    private int $earnRateBonusBasisPoints;

    #[ORM\Column]
    private int $permanentDiscountBasisPoints;

    #[ORM\Column]
    private int $sortOrder;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getThresholdKopecks(): int
    {
        return $this->thresholdKopecks;
    }

    public function setThresholdKopecks(int $thresholdKopecks): void
    {
        $this->thresholdKopecks = $thresholdKopecks;
    }

    public function getEarnRateBonusBasisPoints(): int
    {
        return $this->earnRateBonusBasisPoints;
    }

    public function setEarnRateBonusBasisPoints(int $earnRateBonusBasisPoints): void
    {
        $this->earnRateBonusBasisPoints = $earnRateBonusBasisPoints;
    }

    public function getPermanentDiscountBasisPoints(): int
    {
        return $this->permanentDiscountBasisPoints;
    }

    public function setPermanentDiscountBasisPoints(int $permanentDiscountBasisPoints): void
    {
        $this->permanentDiscountBasisPoints = $permanentDiscountBasisPoints;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
    }
}
