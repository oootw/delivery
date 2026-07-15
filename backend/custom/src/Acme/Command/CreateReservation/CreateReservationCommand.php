<?php

declare(strict_types=1);

namespace App\Custom\Acme\Command\CreateReservation;

class CreateReservationCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly int $workspaceId,
        public readonly int $venueId,
        public readonly string $guestName,
        public readonly string $guestPhone,
        public readonly int $peopleCount,
        public readonly \DateTimeImmutable $desiredAt,
    ) {}
}
