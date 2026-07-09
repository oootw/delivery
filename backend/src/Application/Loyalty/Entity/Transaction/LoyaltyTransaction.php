<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Transaction;

/**
 * Запись леджера баллов (только на добавление). points — знаковое изменение
 * баланса, balanceAfter — баланс после операции. Используется для истории гостя.
 */
class LoyaltyTransaction
{
    public function __construct(
        public ?int $id,
        public int $accountId,
        public int $workspaceId,
        public ?int $orderId,
        public LoyaltyTransactionTypeEnum $type,
        public int $points,
        public int $balanceAfter,
        public ?string $comment,
        public \DateTimeImmutable $createdAt,
    ) {}

    public static function buildNew(
        int $accountId,
        int $workspaceId,
        ?int $orderId,
        LoyaltyTransactionTypeEnum $type,
        int $points,
        int $balanceAfter,
        ?string $comment = null,
    ): self {
        return new self(
            id: null,
            accountId: $accountId,
            workspaceId: $workspaceId,
            orderId: $orderId,
            type: $type,
            points: $points,
            balanceAfter: $balanceAfter,
            comment: $comment,
            createdAt: new \DateTimeImmutable(),
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
