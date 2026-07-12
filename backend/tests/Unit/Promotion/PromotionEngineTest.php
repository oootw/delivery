<?php

declare(strict_types=1);

namespace App\Tests\Unit\Promotion;

use App\Application\Promotion\Entity\Promotion\Promotion;
use App\Application\Promotion\Entity\Promotion\PromotionConditions;
use App\Application\Promotion\Entity\Promotion\PromotionContext;
use App\Application\Promotion\Entity\Promotion\PromotionTargetEnum;
use App\Application\Promotion\Entity\Promotion\PromotionTypeEnum;
use App\Application\Promotion\Entity\Promotion\RewardTypeEnum;
use App\Application\Promotion\Service\PromotionEngine;
use PHPUnit\Framework\TestCase;

final class PromotionEngineTest extends TestCase
{
    private PromotionEngine $engine;

    protected function setUp(): void
    {
        $this->engine = new PromotionEngine();
    }

    public function testNoCandidatesGivesNoDiscount(): void
    {
        $result = $this->engine->apply([], $this->context(subtotalKopecks: 100_000));

        self::assertSame(0, $result->totalDiscountKopecks);
        self::assertSame([], $result->applied);
    }

    public function testStackablePromotionsSum(): void
    {
        $candidates = [
            $this->promotion(id: 1, name: 'A', rewardValue: 10_000, priority: 10, stackable: true),
            $this->promotion(id: 2, name: 'B', rewardValue: 5_000, priority: 5, stackable: true),
        ];

        $result = $this->engine->apply($candidates, $this->context(subtotalKopecks: 100_000));

        self::assertSame(15_000, $result->totalDiscountKopecks);
        self::assertCount(2, $result->applied);
    }

    public function testExclusivePromotionWinsAloneAndStops(): void
    {
        // Не-stackable с высшим приоритетом вытесняет остальные.
        $candidates = [
            $this->promotion(id: 1, name: 'Exclusive', rewardValue: 10_000, priority: 10, stackable: false),
            $this->promotion(id: 2, name: 'B', rewardValue: 5_000, priority: 5, stackable: true),
        ];

        $result = $this->engine->apply($candidates, $this->context(subtotalKopecks: 100_000));

        self::assertSame(10_000, $result->totalDiscountKopecks);
        self::assertCount(1, $result->applied);
        self::assertSame('Exclusive', $result->applied[0]->name);
    }

    public function testStackableThenExclusiveStopsWithoutApplyingExclusive(): void
    {
        // Сначала применяется stackable (высший приоритет), затем не-stackable завершает
        // подбор, но сам не применяется (набор уже не пуст).
        $candidates = [
            $this->promotion(id: 1, name: 'Stackable', rewardValue: 10_000, priority: 10, stackable: true),
            $this->promotion(id: 2, name: 'Exclusive', rewardValue: 5_000, priority: 5, stackable: false),
        ];

        $result = $this->engine->apply($candidates, $this->context(subtotalKopecks: 100_000));

        self::assertSame(10_000, $result->totalDiscountKopecks);
        self::assertCount(1, $result->applied);
        self::assertSame('Stackable', $result->applied[0]->name);
    }

    public function testDiscountCappedToKeepMinimumPayable(): void
    {
        // Скидка больше суммы: к оплате всё равно остаётся минимум (100 коп).
        $candidates = [
            $this->promotion(id: 1, name: 'Big', rewardValue: 20_000, priority: 10, stackable: true),
        ];

        $result = $this->engine->apply($candidates, $this->context(subtotalKopecks: 10_000));

        self::assertSame(9_900, $result->totalDiscountKopecks);
    }

    public function testHigherPriorityAppliesFirstWhenStacking(): void
    {
        // Порядок кандидатов на входе не важен — движок сортирует по приоритету.
        $candidates = [
            $this->promotion(id: 2, name: 'Low', rewardValue: 3_000, priority: 1, stackable: true),
            $this->promotion(id: 1, name: 'High', rewardValue: 7_000, priority: 9, stackable: true),
        ];

        $result = $this->engine->apply($candidates, $this->context(subtotalKopecks: 100_000));

        self::assertSame(10_000, $result->totalDiscountKopecks);
        self::assertSame('High', $result->applied[0]->name);
        self::assertSame('Low', $result->applied[1]->name);
    }

    private function context(int $subtotalKopecks): PromotionContext
    {
        return new PromotionContext(
            customerId: 1,
            orderType: 'pickup',
            subtotalKopecks: $subtotalKopecks,
            now: new \DateTimeImmutable('2026-07-11 12:00:00'),
            timezone: 'Europe/Moscow',
            isFirstOrder: false,
            lines: [],
        );
    }

    private function promotion(int $id, string $name, int $rewardValue, int $priority, bool $stackable): Promotion
    {
        $now = new \DateTimeImmutable();

        return new Promotion(
            id: $id,
            workspaceId: 1,
            venueId: null,
            name: $name,
            type: PromotionTypeEnum::Automatic,
            code: null,
            rewardType: RewardTypeEnum::FixedAmount,
            rewardValue: $rewardValue,
            target: PromotionTargetEnum::Order,
            targetRefs: [],
            conditions: PromotionConditions::fromArray([]),
            priority: $priority,
            stackable: $stackable,
            maxRedemptions: null,
            maxRedemptionsPerCustomer: null,
            redemptionsCount: 0,
            isActive: true,
            createdAt: $now,
            updatedAt: $now,
        );
    }
}
