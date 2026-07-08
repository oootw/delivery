<?php

declare(strict_types=1);

namespace App\Application\Venue\Command\CreateVenue;

class CreatedVenueDTO
{
    public function __construct(
        public readonly int $id,
    ) {}
}
