<?php

declare(strict_types=1);

namespace App\Tests\Unit\Loyalty;

use App\Application\Loyalty\Entity\Transaction\LoyaltyTransaction;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionTypeEnum;
use App\Application\Loyalty\Service\PointsExpiryCalculator;
use PHPUnit\Framework\TestCase;

final class PointsExpiryCalculatorTest extends TestCase
{
    private PointsExpiryCalculator $calculator;
    private \DateTimeImmutable $cutoff;

    protected function setUp(): void
    {
        $this->calculator = new PointsExpiryCalculator();
        // Всё, начисленное раньше этого момента, считается просроченным.
        $this->cutoff = new \DateTimeImmutable('2026-07-01 00:00:00');
    }

    public function testNothingExpiresWhenAllEarnsAreRecent(): void
    {
        $ledger = [
            $this->earn(500, '2026-07-05'),
            $this->earn(300, '2026-07-06'),
        ];

        self::assertSame(0, $this->calculator->expiredPoints($ledger, $this->cutoff));
    }

    public function testOldUnspentEarnExpires(): void
    {
        $ledger = [
            $this->earn(500, '2026-06-01'),
            $this->earn(300, '2026-07-06'),
        ];

        // Сгорают только старые 500; свежие 300 остаются.
        self::assertSame(500, $this->calculator->expiredPoints($ledger, $this->cutoff));
    }

    public function testSpendConsumesOldestFirstSoRecentSurvives(): void
    {
        $ledger = [
            $this->earn(500, '2026-06-01'),
            $this->earn(400, '2026-07-06'),
            $this->tx(LoyaltyTransactionTypeEnum::RedeemFinalize, -500, '2026-07-07'),
        ];

        // Списание 500 съедает старейший лот целиком → к cutoff просроченного не осталось.
        self::assertSame(0, $this->calculator->expiredPoints($ledger, $this->cutoff));
    }

    public function testPartialSpendLeavesRemainderOfOldLotExpiring(): void
    {
        $ledger = [
            $this->earn(500, '2026-06-01'),
            $this->tx(LoyaltyTransactionTypeEnum::RedeemFinalize, -200, '2026-07-07'),
        ];

        // Из старого лота 500 потрачено 200 → просрочен остаток 300.
        self::assertSame(300, $this->calculator->expiredPoints($ledger, $this->cutoff));
    }

    public function testPreviousExpireEntryMakesResultIdempotent(): void
    {
        $ledger = [
            $this->earn(500, '2026-06-01'),
            // Прошлый запуск крона уже сжёг этот лот.
            $this->tx(LoyaltyTransactionTypeEnum::Expire, -500, '2026-07-02'),
        ];

        self::assertSame(0, $this->calculator->expiredPoints($ledger, $this->cutoff));
    }

    public function testRefundCreatesFreshLotDatedAtRefund(): void
    {
        $ledger = [
            $this->tx(LoyaltyTransactionTypeEnum::Refund, 200, '2026-07-06'),
        ];

        // Возврат датирован свежим временем → не сгорает.
        self::assertSame(0, $this->calculator->expiredPoints($ledger, $this->cutoff));
    }

    private function earn(int $points, string $date): LoyaltyTransaction
    {
        return $this->tx(LoyaltyTransactionTypeEnum::Earn, $points, $date);
    }

    private function tx(LoyaltyTransactionTypeEnum $type, int $points, string $date): LoyaltyTransaction
    {
        return new LoyaltyTransaction(
            id: null,
            accountId: 1,
            workspaceId: 1,
            orderId: null,
            type: $type,
            points: $points,
            balanceAfter: 0,
            comment: null,
            createdAt: new \DateTimeImmutable($date . ' 12:00:00'),
        );
    }
}
