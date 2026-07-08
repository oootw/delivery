<?php

declare(strict_types=1);

namespace App\Application\WaitTime\Command\SetKitchenProfile;

class Command
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $venueId,
        public readonly int $baseMinutes,
        public readonly int $perUnitMinutes,
        public readonly int $parallelCapacity,
        public readonly int $deliveryMinutes,
    ) {}
}
