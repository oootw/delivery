<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Account;

/**
 * Бонусный кошелёк гостя в воркспейсе. reservedPoints — баллы, зарезервированные
 * под неоплаченные заказы; к трате доступно pointsBalance − reservedPoints.
 * Инвариант: баланс и резерв неотрицательны, резерв не больше баланса.
 */
class LoyaltyAccount
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public int $customerId,
        public int $pointsBalance,
        public int $reservedPoints,
        public int $lifetimeSpentKopecks,
        public ?int $currentTierId,
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
            pointsBalance: 0,
            reservedPoints: 0,
            lifetimeSpentKopecks: 0,
            currentTierId: null,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function availablePoints(): int
    {
        return $this->pointsBalance - $this->reservedPoints;
    }

    public function reserve(int $points): void
    {
        if ($points <= 0) {
            return;
        }

        if ($points > $this->availablePoints()) {
            throw new \DomainException('Недостаточно баллов для списания');
        }

        $this->reservedPoints += $points;
        $this->touch();
    }

    public function releaseReserve(int $points): void
    {
        $this->reservedPoints = max(0, $this->reservedPoints - $points);
        $this->touch();
    }

    /** Резерв превращается в фактическое списание при оплате. */
    public function finalizeReserve(int $points): void
    {
        $this->reservedPoints = max(0, $this->reservedPoints - $points);
        $this->pointsBalance = max(0, $this->pointsBalance - $points);
        $this->touch();
    }

    public function earn(int $points): void
    {
        if ($points <= 0) {
            return;
        }

        $this->pointsBalance += $points;
        $this->touch();
    }

    /** Возврат ранее списанных баллов (отмена оплаченного заказа). */
    public function refund(int $points): void
    {
        if ($points <= 0) {
            return;
        }

        $this->pointsBalance += $points;
        $this->touch();
    }

    /** Учесть оплаченный заказ в сумме трат за всё время (для расчёта уровня). */
    public function recordSpend(int $netPaidKopecks): void
    {
        if ($netPaidKopecks <= 0) {
            return;
        }

        $this->lifetimeSpentKopecks += $netPaidKopecks;
        $this->touch();
    }

    /** Откат трат при отмене ранее завершённого заказа (уровень может понизиться). */
    public function reduceSpend(int $netPaidKopecks): void
    {
        if ($netPaidKopecks <= 0) {
            return;
        }

        $this->lifetimeSpentKopecks = max(0, $this->lifetimeSpentKopecks - $netPaidKopecks);
        $this->touch();
    }

    public function setTier(?int $tierId): void
    {
        $this->currentTierId = $tierId;
        $this->touch();
    }

    public function adjust(int $deltaPoints): void
    {
        if ($this->pointsBalance + $deltaPoints < 0) {
            throw new \DomainException('Баланс баллов не может стать отрицательным');
        }

        $this->pointsBalance += $deltaPoints;
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
