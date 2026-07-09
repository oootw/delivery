<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoyaltyAccountRepository::class)]
#[ORM\Table(name: 'loyalty_account')]
#[ORM\UniqueConstraint(name: 'uniq_loyalty_account_customer', columns: ['workspace_id', 'customer_id'])]
class LoyaltyAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column]
    private int $customerId;

    #[ORM\Column]
    private int $pointsBalance = 0;

    #[ORM\Column]
    private int $reservedPoints = 0;

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

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getPointsBalance(): int
    {
        return $this->pointsBalance;
    }

    public function setPointsBalance(int $pointsBalance): void
    {
        $this->pointsBalance = $pointsBalance;
    }

    public function getReservedPoints(): int
    {
        return $this->reservedPoints;
    }

    public function setReservedPoints(int $reservedPoints): void
    {
        $this->reservedPoints = $reservedPoints;
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
