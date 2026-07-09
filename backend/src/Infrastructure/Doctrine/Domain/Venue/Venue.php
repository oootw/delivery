<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Venue;

use App\Infrastructure\Doctrine\Domain\Venue\VenueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenueRepository::class)]
#[ORM\Table(name: 'venue')]
#[ORM\Index(name: 'idx_venue_workspace', columns: ['workspace_id'])]
class Venue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 500)]
    private string $address;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column]
    private bool $supportsDelivery;

    #[ORM\Column]
    private bool $supportsPickup;

    #[ORM\Column(nullable: true)]
    private ?int $deliveryRadiusMeters = null;

    /** @var array<int, array{weekday: int, opens_at: string, closes_at: string}> */
    #[ORM\Column(type: Types::JSON)]
    private array $workingHours = [];

    #[ORM\Column(length: 64)]
    private string $timezone = 'Europe/Moscow';

    #[ORM\Column]
    private bool $isActive;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkspaceId(): int
    {
        return $this->workspaceId;
    }

    public function setWorkspaceId(int $workspaceId): void
    {
        $this->workspaceId = $workspaceId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function isSupportsDelivery(): bool
    {
        return $this->supportsDelivery;
    }

    public function setSupportsDelivery(bool $supportsDelivery): void
    {
        $this->supportsDelivery = $supportsDelivery;
    }

    public function isSupportsPickup(): bool
    {
        return $this->supportsPickup;
    }

    public function setSupportsPickup(bool $supportsPickup): void
    {
        $this->supportsPickup = $supportsPickup;
    }

    public function getDeliveryRadiusMeters(): ?int
    {
        return $this->deliveryRadiusMeters;
    }

    public function setDeliveryRadiusMeters(?int $deliveryRadiusMeters): void
    {
        $this->deliveryRadiusMeters = $deliveryRadiusMeters;
    }

    /** @return array<int, array{weekday: int, opens_at: string, closes_at: string}> */
    public function getWorkingHours(): array
    {
        return $this->workingHours;
    }

    /** @param array<int, array{weekday: int, opens_at: string, closes_at: string}> $workingHours */
    public function setWorkingHours(array $workingHours): void
    {
        $this->workingHours = $workingHours;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): void
    {
        $this->timezone = $timezone;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
