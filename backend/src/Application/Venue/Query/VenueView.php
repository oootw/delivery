<?php

declare(strict_types=1);

namespace App\Application\Venue\Query;

use App\Application\Venue\Entity\Venue\Venue;

/**
 * Read-модель точки для ответов API. Общая для запросов списка и одной точки.
 */
final class VenueView
{
    public function __construct(
        public readonly int $id,
        public readonly int $workspaceId,
        public readonly string $name,
        public readonly string $address,
        public readonly ?float $latitude,
        public readonly ?float $longitude,
        public readonly ?string $phone,
        public readonly bool $supportsDelivery,
        public readonly bool $supportsPickup,
        public readonly ?int $deliveryRadiusMeters,
        /** @var array<int, array{weekday: int, opens_at: string, closes_at: string}> */
        public readonly array $workingHours,
        public readonly string $timezone,
        public readonly bool $isActive,
    ) {}

    public static function fromVenue(Venue $venue): self
    {
        return new self(
            id: $venue->id,
            workspaceId: $venue->workspaceId,
            name: $venue->name,
            address: $venue->address,
            latitude: $venue->latitude,
            longitude: $venue->longitude,
            phone: $venue->phone,
            supportsDelivery: $venue->supportsDelivery,
            supportsPickup: $venue->supportsPickup,
            deliveryRadiusMeters: $venue->deliveryRadiusMeters,
            workingHours: $venue->workingHours->toArray(),
            timezone: $venue->timezone,
            isActive: $venue->isActive,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'workspace_id' => $this->workspaceId,
            'name' => $this->name,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'phone' => $this->phone,
            'supports_delivery' => $this->supportsDelivery,
            'supports_pickup' => $this->supportsPickup,
            'delivery_radius_meters' => $this->deliveryRadiusMeters,
            'working_hours' => $this->workingHours,
            'timezone' => $this->timezone,
            'is_active' => $this->isActive,
        ];
    }
}
