<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Promotion;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'promotion_redemption')]
#[ORM\Index(name: 'idx_promo_redemption_order', columns: ['order_id'])]
#[ORM\Index(name: 'idx_promo_redemption_customer', columns: ['promotion_id', 'customer_id'])]
#[ORM\UniqueConstraint(name: 'uniq_promo_redemption_promo_order', columns: ['promotion_id', 'order_id'])]
class PromotionRedemption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $promotionId;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column]
    private int $orderId;

    #[ORM\Column]
    private int $customerId;

    #[ORM\Column]
    private int $discountKopecks;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPromotionId(): int
    {
        return $this->promotionId;
    }

    public function setPromotionId(int $promotionId): void
    {
        $this->promotionId = $promotionId;
    }

    public function getWorkspaceId(): int
    {
        return $this->workspaceId;
    }

    public function setWorkspaceId(int $workspaceId): void
    {
        $this->workspaceId = $workspaceId;
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

    public function getDiscountKopecks(): int
    {
        return $this->discountKopecks;
    }

    public function setDiscountKopecks(int $discountKopecks): void
    {
        $this->discountKopecks = $discountKopecks;
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
