<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Stamp;

/**
 * Программа штампов воркспейса (одна на воркспейс). Каждый завершённый заказ даёт
 * гостю один штамп; при наборе requiredCount выдаётся награда — rewardPoints баллов
 * на бонусный кошелёк, а счётчик уменьшается на requiredCount (переполнение остаётся).
 */
class StampProgram
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public bool $isEnabled,
        public int $requiredCount,
        public int $rewardPoints,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(int $workspaceId): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            workspaceId: $workspaceId,
            isEnabled: false,
            requiredCount: 1,
            rewardPoints: 0,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function update(bool $isEnabled, int $requiredCount, int $rewardPoints): void
    {
        if ($requiredCount < 1) {
            throw new \DomainException('Число штампов для награды должно быть не меньше 1');
        }

        if ($rewardPoints < 1) {
            throw new \DomainException('Награда в баллах должна быть больше нуля');
        }

        $this->isEnabled = $isEnabled;
        $this->requiredCount = $requiredCount;
        $this->rewardPoints = $rewardPoints;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
