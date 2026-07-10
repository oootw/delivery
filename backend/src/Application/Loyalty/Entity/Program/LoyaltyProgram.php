<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Program;

/**
 * Настройки бонусной программы воркспейса (одна на воркспейс). Кэшбэк начисляется
 * от оплаченной суммы (net paid) при завершении заказа, курс балла — pointValueKopecks
 * (по умолчанию 100 — 1 балл = 1 рубль). Оплата баллами ограничена долей суммы заказа.
 * Начисление округляется вниз.
 */
class LoyaltyProgram
{
    /** Итог к оплате не может опуститься ниже этого порога (нулевой онлайн-платёж невозможен). */
    private const MIN_PAYABLE_KOPECKS = 100;

    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public bool $isEnabled,
        public int $earnRateBasisPoints,
        public int $pointValueKopecks,
        public int $redeemMaxPercentBasisPoints,
        public ?int $pointsLifetimeDays,
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
            earnRateBasisPoints: 0,
            pointValueKopecks: 100,
            redeemMaxPercentBasisPoints: 5000,
            pointsLifetimeDays: null,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function update(
        bool $isEnabled,
        int $earnRateBasisPoints,
        int $pointValueKopecks,
        int $redeemMaxPercentBasisPoints,
        ?int $pointsLifetimeDays,
    ): void {
        if ($earnRateBasisPoints < 0 || $earnRateBasisPoints > 10000) {
            throw new \DomainException('Процент кэшбэка должен быть от 0 до 100%');
        }

        if ($pointValueKopecks < 1) {
            throw new \DomainException('Курс балла должен быть не меньше 1 копейки');
        }

        if ($redeemMaxPercentBasisPoints < 0 || $redeemMaxPercentBasisPoints > 10000) {
            throw new \DomainException('Лимит оплаты баллами должен быть от 0 до 100%');
        }

        if ($pointsLifetimeDays !== null && $pointsLifetimeDays < 1) {
            throw new \DomainException('Срок жизни баллов должен быть положительным числом дней');
        }

        $this->isEnabled = $isEnabled;
        $this->earnRateBasisPoints = $earnRateBasisPoints;
        $this->pointValueKopecks = $pointValueKopecks;
        $this->redeemMaxPercentBasisPoints = $redeemMaxPercentBasisPoints;
        $this->pointsLifetimeDays = $pointsLifetimeDays;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * Начисляемые баллы за оплаченную сумму (округление вниз). Прибавка уровня
     * (tierBonusBasisPoints) суммируется с базовым процентом кэшбэка, но итоговая
     * ставка не превышает 100%.
     */
    public function earnPointsFor(int $netPaidKopecks, int $tierBonusBasisPoints = 0): int
    {
        if (!$this->isEnabled || $netPaidKopecks <= 0) {
            return 0;
        }

        $rate = min(10000, $this->earnRateBasisPoints + max(0, $tierBonusBasisPoints));
        $cashbackKopecks = intdiv($netPaidKopecks * $rate, 10000);

        return intdiv($cashbackKopecks, $this->pointValueKopecks);
    }

    /**
     * Сколько баллов можно списать: не больше желаемого, доступного баланса и лимита от
     * суммы заказа; итог к оплате не опускается ниже минимума.
     */
    public function redeemablePoints(int $desiredPoints, int $availablePoints, int $baseKopecks): int
    {
        if (!$this->isEnabled || $desiredPoints <= 0 || $availablePoints <= 0) {
            return 0;
        }

        $capByPercent = intdiv($baseKopecks * $this->redeemMaxPercentBasisPoints, 10000);
        $capByFloor = max(0, $baseKopecks - self::MIN_PAYABLE_KOPECKS);
        $maxDiscountKopecks = min($capByPercent, $capByFloor);
        $maxPointsByBase = intdiv($maxDiscountKopecks, $this->pointValueKopecks);

        return max(0, min($desiredPoints, $availablePoints, $maxPointsByBase));
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
