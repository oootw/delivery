<?php

declare(strict_types=1);

namespace App\Application\Venue\Command\ChangeVenueActivity;

class Command
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $venueId,
        public readonly bool $isActive,
    ) {}
}
