<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use App\Application\Loyalty\Entity\Redemption\LoyaltyRedemptionStatusEnum;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoyaltyRedemptionRepository::class)]
#[ORM\Table(name: 'loyalty_redemption')]
#[ORM\UniqueConstraint(name: 'uniq_loyalty_redemption_order', columns: ['order_id'])]
#[ORM\Index(name: 'idx_loyalty_redemption_account', columns: ['account_id'])]
class LoyaltyRedemption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column]
    private int $accountId;

    #[ORM\Column]
    private int $orderId;

    #[ORM\Column]
    private int $customerId;

    #[ORM\Column]
    private int $points;

    #[ORM\Column(length: 20, enumType: LoyaltyRedemptionStatusEnum::class)]
    private LoyaltyRedemptionStatusEnum $status;

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

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function setAccountId(int $accountId): void
    {
        $this->accountId = $accountId;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    public function getStatus(): LoyaltyRedemptionStatusEnum
    {
        return $this->status;
    }

    public function setStatus(LoyaltyRedemptionStatusEnum $status): void
    {
        $this->status = $status;
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
