<?php

declare(strict_types=1);

namespace App\Tests\Unit\Promotion;

use App\Application\Promotion\Entity\Promotion\PromotionConditions;
use App\Application\Promotion\Entity\Promotion\PromotionContext;
use PHPUnit\Framework\TestCase;

final class PromotionConditionsTest extends TestCase
{
    public function testEmptyConditionsAlwaysSatisfied(): void
    {
        self::assertTrue(PromotionConditions::fromArray([])->isSatisfiedBy($this->context()));
    }

    public function testMinTotalGate(): void
    {
        $conditions = PromotionConditions::fromArray(['min_total_kopecks' => 50_000]);

        self::assertFalse($conditions->isSatisfiedBy($this->context(subtotalKopecks: 40_000)));
        self::assertTrue($conditions->isSatisfiedBy($this->context(subtotalKopecks: 60_000)));
    }

    public function testOrderTypeGate(): void
    {
        $conditions = PromotionConditions::fromArray(['order_types' => ['delivery']]);

        self::assertFalse($conditions->isSatisfiedBy($this->context(orderType: 'pickup')));
        self::assertTrue($conditions->isSatisfiedBy($this->context(orderType: 'delivery')));
    }

    public function testFirstOrderGate(): void
    {
        $conditions = PromotionConditions::fromArray(['first_order_only' => true]);

        self::assertFalse($conditions->isSatisfiedBy($this->context(isFirstOrder: false)));
        self::assertTrue($conditions->isSatisfiedBy($this->context(isFirstOrder: true)));
    }

    public function testValidityWindow(): void
    {
        $conditions = PromotionConditions::fromArray([
            'valid_from' => '2026-07-01',
            'valid_to' => '2026-07-31',
        ]);

        // now = 2026-07-11 — внутри окна.
        self::assertTrue($conditions->isSatisfiedBy($this->context()));

        $future = PromotionConditions::fromArray(['valid_from' => '2026-08-01']);
        self::assertFalse($future->isSatisfiedBy($this->context()));
    }

    public function testDaysOfWeekByVenueTimezone(): void
    {
        // now в MSK — суббота (N=6).
        $saturday = PromotionConditions::fromArray(['days_of_week' => [6]]);
        self::assertTrue($saturday->isSatisfiedBy($this->context()));

        $monday = PromotionConditions::fromArray(['days_of_week' => [1]]);
        self::assertFalse($monday->isSatisfiedBy($this->context()));
    }

    public function testHappyHoursWindow(): void
    {
        // Локальное время 15:00 MSK.
        $daytime = PromotionConditions::fromArray(['time_from' => '10:00', 'time_to' => '18:00']);
        self::assertTrue($daytime->isSatisfiedBy($this->context()));

        $evening = PromotionConditions::fromArray(['time_from' => '18:00', 'time_to' => '22:00']);
        self::assertFalse($evening->isSatisfiedBy($this->context()));
    }

    public function testHappyHoursWindowAcrossMidnight(): void
    {
        // Окно через полночь 22:00–02:00.
        $overnight = PromotionConditions::fromArray(['time_from' => '22:00', 'time_to' => '02:00']);

        // Локальное 15:00 — вне окна.
        self::assertFalse($overnight->isSatisfiedBy($this->context()));

        // UTC 20:00 → MSK 23:00 — внутри окна.
        self::assertTrue($overnight->isSatisfiedBy(
            $this->context(now: new \DateTimeImmutable('2026-07-11 20:00:00', new \DateTimeZone('UTC'))),
        ));
    }

    private function context(
        int $subtotalKopecks = 100_000,
        string $orderType = 'pickup',
        bool $isFirstOrder = false,
        ?\DateTimeImmutable $now = null,
    ): PromotionContext {
        return new PromotionContext(
            customerId: 1,
            orderType: $orderType,
            subtotalKopecks: $subtotalKopecks,
            now: $now ?? new \DateTimeImmutable('2026-07-11 12:00:00', new \DateTimeZone('UTC')),
            timezone: 'Europe/Moscow',
            isFirstOrder: $isFirstOrder,
            lines: [],
        );
    }
}
