<?php

declare(strict_types=1);

namespace App\Tests\Unit\Loyalty;

use App\Application\Loyalty\Entity\Program\LoyaltyProgram;
use PHPUnit\Framework\TestCase;

final class LoyaltyProgramTest extends TestCase
{
    public function testDisabledProgramEarnsNothing(): void
    {
        $program = $this->program(isEnabled: false, earnRateBasisPoints: 500);

        self::assertSame(0, $program->earnPointsFor(100_000));
    }

    public function testEarnAppliesRateAndPointValueWithFloor(): void
    {
        // 5% от 1000₽ = 50₽ кэшбэка; при 1 балл = 1₽ (100 коп) это 50 баллов.
        $program = $this->program(earnRateBasisPoints: 500, pointValueKopecks: 100);

        self::assertSame(50, $program->earnPointsFor(100_000));
    }

    public function testEarnAddsTierBonusToRate(): void
    {
        // (5% + 2%) от 1000₽ = 70₽ = 70 баллов.
        $program = $this->program(earnRateBasisPoints: 500, pointValueKopecks: 100);

        self::assertSame(70, $program->earnPointsFor(100_000, 200));
    }

    public function testEarnRateIsCappedAtHundredPercent(): void
    {
        // 90% + 50% → ограничено 100%: кэшбэк = вся сумма = 1000 баллов.
        $program = $this->program(earnRateBasisPoints: 9000, pointValueKopecks: 100);

        self::assertSame(1000, $program->earnPointsFor(100_000, 5000));
    }

    public function testEarnZeroForNonPositivePaid(): void
    {
        $program = $this->program(earnRateBasisPoints: 500);

        self::assertSame(0, $program->earnPointsFor(0));
    }

    public function testRedeemCappedByPercentOfOrder(): void
    {
        // Лимит 50% от 1000₽ = 500₽ = 500 баллов, хотя гость хочет и может больше.
        $program = $this->program(redeemMaxPercentBasisPoints: 5000, pointValueKopecks: 100);

        self::assertSame(500, $program->redeemablePoints(1000, 1000, 100_000));
    }

    public function testRedeemLimitedByDesiredAndAvailable(): void
    {
        $program = $this->program(redeemMaxPercentBasisPoints: 5000, pointValueKopecks: 100);

        self::assertSame(200, $program->redeemablePoints(200, 1000, 100_000));
        self::assertSame(100, $program->redeemablePoints(1000, 100, 100_000));
    }

    public function testRedeemBlockedWhenOrderTooSmallToKeepMinimum(): void
    {
        // База 100 коп: floor не даёт опустить итог ниже MIN_PAYABLE (100 коп) → 0 баллов.
        $program = $this->program(redeemMaxPercentBasisPoints: 10000, pointValueKopecks: 100);

        self::assertSame(0, $program->redeemablePoints(1000, 1000, 100));
    }

    public function testDisabledProgramRedeemsNothing(): void
    {
        $program = $this->program(isEnabled: false, redeemMaxPercentBasisPoints: 5000);

        self::assertSame(0, $program->redeemablePoints(1000, 1000, 100_000));
    }

    private function program(
        bool $isEnabled = true,
        int $earnRateBasisPoints = 0,
        int $pointValueKopecks = 100,
        int $redeemMaxPercentBasisPoints = 5000,
    ): LoyaltyProgram {
        $now = new \DateTimeImmutable();

        return new LoyaltyProgram(
            id: 1,
            workspaceId: 1,
            isEnabled: $isEnabled,
            earnRateBasisPoints: $earnRateBasisPoints,
            pointValueKopecks: $pointValueKopecks,
            redeemMaxPercentBasisPoints: $redeemMaxPercentBasisPoints,
            pointsLifetimeDays: null,
            createdAt: $now,
            updatedAt: $now,
        );
    }
}
