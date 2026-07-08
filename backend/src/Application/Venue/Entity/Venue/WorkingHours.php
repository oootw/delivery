<?php

declare(strict_types=1);

namespace App\Application\Venue\Entity\Venue;

/**
 * Недельное расписание работы точки — набор дневных интервалов.
 * Дни, которых нет в списке, считаются выходными.
 */
final class WorkingHours
{
    /**
     * @param DaySchedule[] $days
     */
    private function __construct(
        public readonly array $days,
    ) {}

    /**
     * @param DaySchedule[] $days
     */
    public static function fromDays(array $days): self
    {
        return new self(array_values($days));
    }

    public static function closed(): self
    {
        return new self([]);
    }

    /**
     * @return array<int, array{weekday: int, opens_at: string, closes_at: string}>
     */
    public function toArray(): array
    {
        return array_map(
            fn(DaySchedule $day): array => [
                'weekday' => $day->weekday,
                'opens_at' => $day->opensAt,
                'closes_at' => $day->closesAt,
            ],
            $this->days,
        );
    }

    /**
     * @param array<int, array{weekday: int, opens_at: string, closes_at: string}> $days
     */
    public static function fromArray(array $days): self
    {
        return self::fromDays(
            array_map(
                fn(array $day): DaySchedule => new DaySchedule(
                    weekday: $day['weekday'],
                    opensAt: $day['opens_at'],
                    closesAt: $day['closes_at'],
                ),
                $days,
            ),
        );
    }
}
