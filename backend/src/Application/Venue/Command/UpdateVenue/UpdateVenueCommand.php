<?php

declare(strict_types=1);

namespace App\Application\Venue\Command\UpdateVenue;

class UpdateVenueCommand
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $venueId,
        public readonly string $name,
        public readonly string $address,
        public readonly ?float $latitude,
        public readonly ?float $longitude,
        public readonly ?string $phone,
        public readonly bool $supportsDelivery,
        public readonly bool $supportsPickup,
        public readonly ?int $deliveryRadiusMeters,
        public readonly ?string $timezone = null,
    ) {}
}
