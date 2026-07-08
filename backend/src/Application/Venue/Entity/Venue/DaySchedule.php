<?php

declare(strict_types=1);

namespace App\Application\Venue\Entity\Venue;

/**
 * Часы работы точки в один день недели.
 * weekday: 1 (понедельник) .. 7 (воскресенье); время в формате HH:MM.
 */
final class DaySchedule
{
    public function __construct(
        public readonly int $weekday,
        public readonly string $opensAt,
        public readonly string $closesAt,
    ) {}
}
