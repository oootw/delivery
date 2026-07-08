<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\WaitTime;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KitchenProfileRepository::class)]
#[ORM\Table(name: 'kitchen_profile')]
#[ORM\UniqueConstraint(name: 'uniq_kitchen_profile_venue', columns: ['venue_id'])]
class KitchenProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $venueId;

    #[ORM\Column]
    private int $baseMinutes;

    #[ORM\Column]
    private int $perUnitMinutes;

    #[ORM\Column]
    private int $parallelCapacity;

    #[ORM\Column]
    private int $deliveryMinutes;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVenueId(): int
    {
        return $this->venueId;
    }

    public function setVenueId(int $venueId): void
    {
        $this->venueId = $venueId;
    }

    public function getBaseMinutes(): int
    {
        return $this->baseMinutes;
    }

    public function setBaseMinutes(int $baseMinutes): void
    {
        $this->baseMinutes = $baseMinutes;
    }

    public function getPerUnitMinutes(): int
    {
        return $this->perUnitMinutes;
    }

    public function setPerUnitMinutes(int $perUnitMinutes): void
    {
        $this->perUnitMinutes = $perUnitMinutes;
    }

    public function getParallelCapacity(): int
    {
        return $this->parallelCapacity;
    }

    public function setParallelCapacity(int $parallelCapacity): void
    {
        $this->parallelCapacity = $parallelCapacity;
    }

    public function getDeliveryMinutes(): int
    {
        return $this->deliveryMinutes;
    }

    public function setDeliveryMinutes(int $deliveryMinutes): void
    {
        $this->deliveryMinutes = $deliveryMinutes;
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
