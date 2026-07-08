<?php

declare(strict_types=1);

namespace App\Application\Venue\Entity\Venue;

/**
 * Точка (кафе/ресторан) внутри воркспейса.
 * Принадлежит одному воркспейсу; создаётся и управляется владельцем воркспейса.
 */
class Venue
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public string $name,
        public string $address,
        public ?float $latitude,
        public ?float $longitude,
        public ?string $phone,
        public bool $supportsDelivery,
        public bool $supportsPickup,
        public ?int $deliveryRadiusMeters,
        public WorkingHours $workingHours,
        public bool $isActive,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(
        int $workspaceId,
        string $name,
        string $address,
        ?float $latitude,
        ?float $longitude,
        ?string $phone,
        bool $supportsDelivery,
        bool $supportsPickup,
        ?int $deliveryRadiusMeters,
        WorkingHours $workingHours,
    ): self {
        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            workspaceId: $workspaceId,
            name: $name,
            address: $address,
            latitude: $latitude,
            longitude: $longitude,
            phone: $phone,
            supportsDelivery: $supportsDelivery,
            supportsPickup: $supportsPickup,
            deliveryRadiusMeters: $deliveryRadiusMeters,
            workingHours: $workingHours,
            isActive: true,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function updateDetails(
        string $name,
        string $address,
        ?float $latitude,
        ?float $longitude,
        ?string $phone,
        bool $supportsDelivery,
        bool $supportsPickup,
        ?int $deliveryRadiusMeters,
    ): void {
        $this->name = $name;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->phone = $phone;
        $this->supportsDelivery = $supportsDelivery;
        $this->supportsPickup = $supportsPickup;
        $this->deliveryRadiusMeters = $deliveryRadiusMeters;
        $this->touch();
    }

    public function setWorkingHours(WorkingHours $workingHours): void
    {
        $this->workingHours = $workingHours;
        $this->touch();
    }

    public function changeActivity(bool $isActive): void
    {
        $this->isActive = $isActive;
        $this->touch();
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }

    private function touch(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
