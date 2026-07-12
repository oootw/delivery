<?php

declare(strict_types=1);

namespace App\Tests\Unit\WaitTime;

use App\Application\Order\Entity\Order\OrderStatusEnum;
use App\Application\Order\Entity\Order\OrderTypeEnum;
use App\Application\WaitTime\Entity\KitchenProfile\KitchenProfile;
use App\Application\WaitTime\Service\WaitTimeEstimator;
use App\Application\WaitTime\Service\WaitTimeInputs;
use PHPUnit\Framework\TestCase;

final class WaitTimeEstimatorTest extends TestCase
{
    private WaitTimeEstimator $estimator;

    protected function setUp(): void
    {
        $this->estimator = new WaitTimeEstimator();
    }

    public function testTerminalStatusIsZero(): void
    {
        $inputs = $this->inputs(status: OrderStatusEnum::Completed, type: OrderTypeEnum::Pickup);

        self::assertSame(0, $this->estimator->estimateWaitMinutes($inputs));
    }

    public function testPickupWithoutQueueIsBasePlusPerUnit(): void
    {
        // base 10 + perUnit 4 × units 2 = 18, очереди нет.
        $inputs = $this->inputs(status: OrderStatusEnum::Created, type: OrderTypeEnum::Pickup, units: 2);

        self::assertSame(18, $this->estimator->estimateWaitMinutes($inputs));
    }

    public function testQueueAheadAddsProportionalWait(): void
    {
        // own 18; очередь (3 впереди ÷ мощность 3) × 18 = 18; итого 36.
        $inputs = $this->inputs(
            status: OrderStatusEnum::Created,
            type: OrderTypeEnum::Pickup,
            units: 2,
            queueAhead: 3,
        );

        self::assertSame(36, $this->estimator->estimateWaitMinutes($inputs));
    }

    public function testDeliveryAddsLogisticsLeg(): void
    {
        // own 18 + плечо доставки 30 = 48.
        $inputs = $this->inputs(status: OrderStatusEnum::Created, type: OrderTypeEnum::Delivery, units: 2);

        self::assertSame(48, $this->estimator->estimateWaitMinutes($inputs));
    }

    public function testCookingCountsOnlyRemaining(): void
    {
        // own 18, готовится уже 5 минут → осталось 13.
        $inputs = $this->inputs(
            status: OrderStatusEnum::Cooking,
            type: OrderTypeEnum::Pickup,
            units: 2,
            elapsedCookingMinutes: 5,
        );

        self::assertSame(13, $this->estimator->estimateWaitMinutes($inputs));
    }

    public function testCookingOverrunIsClampedToZero(): void
    {
        $inputs = $this->inputs(
            status: OrderStatusEnum::Cooking,
            type: OrderTypeEnum::Pickup,
            units: 2,
            elapsedCookingMinutes: 25,
        );

        self::assertSame(0, $this->estimator->estimateWaitMinutes($inputs));
    }

    public function testHistoricalPerUnitBlendsWithConfigured(): void
    {
        // blended perUnit = 0.5×2 + 0.5×4 = 3; own = 10 + 3×2 = 16.
        $inputs = $this->inputs(
            status: OrderStatusEnum::Created,
            type: OrderTypeEnum::Pickup,
            units: 2,
            historicalPerUnitMinutes: 2.0,
        );

        self::assertSame(16, $this->estimator->estimateWaitMinutes($inputs));
    }

    private function inputs(
        OrderStatusEnum $status,
        OrderTypeEnum $type,
        int $units = 1,
        int $queueAhead = 0,
        ?int $elapsedCookingMinutes = null,
        ?float $historicalPerUnitMinutes = null,
    ): WaitTimeInputs {
        return new WaitTimeInputs(
            status: $status,
            type: $type,
            units: $units,
            profile: $this->profile(),
            queueAhead: $queueAhead,
            elapsedCookingMinutes: $elapsedCookingMinutes,
            historicalPerUnitMinutes: $historicalPerUnitMinutes,
        );
    }

    private function profile(): KitchenProfile
    {
        $now = new \DateTimeImmutable();

        return new KitchenProfile(
            id: 1,
            venueId: 1,
            baseMinutes: 10,
            perUnitMinutes: 4,
            parallelCapacity: 3,
            deliveryMinutes: 30,
            createdAt: $now,
            updatedAt: $now,
        );
    }
}
