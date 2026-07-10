<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Tier;

/**
 * Уровень лояльности воркспейса. Гость получает уровень по сумме трат за всё время
 * (lifetimeSpentKopecks): его уровень — самый высокий tier с порогом не больше трат.
 * Уровень даёт постоянную скидку на заказ (permanentDiscountBasisPoints) и прибавку
 * к проценту кэшбэка (earnRateBonusBasisPoints). Проценты — в базисных пунктах.
 */
class LoyaltyTier
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public string $name,
        public int $thresholdKopecks,
        public int $earnRateBonusBasisPoints,
        public int $permanentDiscountBasisPoints,
        public int $sortOrder,
    ) {}

    public static function buildNew(
        int $workspaceId,
        string $name,
        int $thresholdKopecks,
        int $earnRateBonusBasisPoints,
        int $permanentDiscountBasisPoints,
        int $sortOrder,
    ): self {
        $name = trim($name);

        if ($name === '') {
            throw new \DomainException('Укажите название уровня');
        }

        if ($thresholdKopecks < 0) {
            throw new \DomainException('Порог уровня не может быть отрицательным');
        }

        if ($earnRateBonusBasisPoints < 0 || $earnRateBonusBasisPoints > 10000) {
            throw new \DomainException('Прибавка к кэшбэку должна быть от 0 до 100%');
        }

        if ($permanentDiscountBasisPoints < 0 || $permanentDiscountBasisPoints > 10000) {
            throw new \DomainException('Постоянная скидка уровня должна быть от 0 до 100%');
        }

        return new self(
            id: null,
            workspaceId: $workspaceId,
            name: $name,
            thresholdKopecks: $thresholdKopecks,
            earnRateBonusBasisPoints: $earnRateBonusBasisPoints,
            permanentDiscountBasisPoints: $permanentDiscountBasisPoints,
            sortOrder: $sortOrder,
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
