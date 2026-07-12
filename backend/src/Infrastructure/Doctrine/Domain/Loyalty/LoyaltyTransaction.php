<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionTypeEnum;
use Doctrine\ORM\Mapping as ORM;

// Партиальный уникальный индекс uniq_loyalty_earn_per_order (order_id) WHERE type='earn'
// живёт в миграции Version20260711140000 — атрибутами ORM он не выражается. Он гарантирует
// единственное начисление на заказ (идемпотентность accrueOnCompleted при гонке).
#[ORM\Entity(repositoryClass: LoyaltyTransactionRepository::class)]
#[ORM\Table(name: 'loyalty_transaction')]
#[ORM\Index(name: 'idx_loyalty_transaction_account', columns: ['account_id'])]
#[ORM\Index(name: 'idx_loyalty_transaction_order', columns: ['order_id'])]
class LoyaltyTransaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $accountId;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column(nullable: true)]
    private ?int $orderId = null;

    #[ORM\Column(length: 20, enumType: LoyaltyTransactionTypeEnum::class)]
    private LoyaltyTransactionTypeEnum $type;

    #[ORM\Column]
    private int $points;

    #[ORM\Column]
    private int $balanceAfter;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function setAccountId(int $accountId): void
    {
        $this->accountId = $accountId;
    }

    public function getWorkspaceId(): int
    {
        return $this->workspaceId;
    }

    public function setWorkspaceId(int $workspaceId): void
    {
        $this->workspaceId = $workspaceId;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(?int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getType(): LoyaltyTransactionTypeEnum
    {
        return $this->type;
    }

    public function setType(LoyaltyTransactionTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    public function getBalanceAfter(): int
    {
        return $this->balanceAfter;
    }

    public function setBalanceAfter(int $balanceAfter): void
    {
        $this->balanceAfter = $balanceAfter;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
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
