<?php

declare(strict_types=1);

namespace App\Application\Venue\Service;

use App\Application\Venue\Entity\Venue\DaySchedule;
use App\Application\Venue\Entity\Venue\WorkingHours;

/**
 * Проверяет и собирает недельное расписание из «сырых» данных запроса:
 * день недели 1..7 без повторов, время в формате HH:MM, открытие раньше закрытия.
 */
final class WorkingHoursRule
{
    private const TIME_FORMAT = '/^([01]\d|2[0-3]):[0-5]\d$/';

    /**
     * @param array<int, array{weekday?: mixed, opens_at?: mixed, closes_at?: mixed}> $rawDays
     */
    public function build(array $rawDays): WorkingHours
    {
        $seenWeekdays = [];
        $days = [];

        foreach ($rawDays as $rawDay) {
            $weekday = $rawDay['weekday'] ?? null;
            $opensAt = $rawDay['opens_at'] ?? null;
            $closesAt = $rawDay['closes_at'] ?? null;

            if (!is_int($weekday) || $weekday < 1 || $weekday > 7) {
                throw new \DomainException('День недели должен быть числом от 1 до 7');
            }

            if (isset($seenWeekdays[$weekday])) {
                throw new \DomainException('День недели указан дважды');
            }

            if (!is_string($opensAt) || preg_match(self::TIME_FORMAT, $opensAt) !== 1) {
                throw new \DomainException('Время открытия должно быть в формате HH:MM');
            }

            if (!is_string($closesAt) || preg_match(self::TIME_FORMAT, $closesAt) !== 1) {
                throw new \DomainException('Время закрытия должно быть в формате HH:MM');
            }

            if ($opensAt >= $closesAt) {
                throw new \DomainException('Время открытия должно быть раньше времени закрытия');
            }

            $seenWeekdays[$weekday] = true;
            $days[] = new DaySchedule(weekday: $weekday, opensAt: $opensAt, closesAt: $closesAt);
        }

        return WorkingHours::fromDays($days);
    }
}
