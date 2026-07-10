<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Stamp;

/**
 * Прогресс гостя по карте штампов в воркспейсе. currentStamps растёт на завершённых
 * заказах; при выдаче награды из него вычитается requiredCount (остаток сохраняется).
 */
class StampProgress
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public int $customerId,
        public int $currentStamps,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(int $workspaceId, int $customerId): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            workspaceId: $workspaceId,
            customerId: $customerId,
            currentStamps: 0,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function addStamp(): void
    {
        $this->currentStamps++;
        $this->touch();
    }

    /** Списать штампы за выданную награду (переполнение сверх порога остаётся). */
    public function redeemReward(int $requiredCount): void
    {
        $this->currentStamps = max(0, $this->currentStamps - $requiredCount);
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
