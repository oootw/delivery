<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Redemption;

/**
 * Списание баллов по конкретному заказу и его жизненный цикл: резерв → списание
 * при оплате → возврат при отмене. Один заказ — одна запись.
 */
class LoyaltyRedemption
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public int $accountId,
        public int $orderId,
        public int $customerId,
        public int $points,
        public LoyaltyRedemptionStatusEnum $status,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(int $workspaceId, int $accountId, int $orderId, int $customerId, int $points): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            workspaceId: $workspaceId,
            accountId: $accountId,
            orderId: $orderId,
            customerId: $customerId,
            points: $points,
            status: LoyaltyRedemptionStatusEnum::Reserved,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function isReserved(): bool
    {
        return $this->status === LoyaltyRedemptionStatusEnum::Reserved;
    }

    public function isFinalized(): bool
    {
        return $this->status === LoyaltyRedemptionStatusEnum::Finalized;
    }

    public function finalize(): void
    {
        $this->status = LoyaltyRedemptionStatusEnum::Finalized;
        $this->touch();
    }

    public function release(): void
    {
        $this->status = LoyaltyRedemptionStatusEnum::Released;
        $this->touch();
    }

    public function refund(): void
    {
        $this->status = LoyaltyRedemptionStatusEnum::Refunded;
        $this->touch();
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }

    private function touch(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
