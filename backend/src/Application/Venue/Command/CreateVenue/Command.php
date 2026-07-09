<?php

declare(strict_types=1);

namespace App\Application\Venue\Command\CreateVenue;

class Command
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly string $name,
        public readonly string $address,
        public readonly ?float $latitude,
        public readonly ?float $longitude,
        public readonly ?string $phone,
        public readonly bool $supportsDelivery,
        public readonly bool $supportsPickup,
        public readonly ?int $deliveryRadiusMeters,
        /** @var array<int, array{weekday?: mixed, opens_at?: mixed, closes_at?: mixed}> */
        public readonly array $workingHours,
        public readonly ?string $timezone = null,
    ) {}
}
