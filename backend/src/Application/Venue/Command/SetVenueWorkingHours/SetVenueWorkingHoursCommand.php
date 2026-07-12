<?php

declare(strict_types=1);

namespace App\Application\Venue\Command\SetVenueWorkingHours;

class SetVenueWorkingHoursCommand
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $venueId,
        /** @var array<int, array{weekday?: mixed, opens_at?: mixed, closes_at?: mixed}> */
        public readonly array $workingHours,
    ) {}
}
