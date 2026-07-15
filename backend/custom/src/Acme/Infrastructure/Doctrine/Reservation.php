<?php

declare(strict_types=1);

namespace App\Custom\Acme\Infrastructure\Doctrine;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ORM\Table(name: 'custom_acme_reservation')]
#[ORM\Index(name: 'idx_custom_acme_reservation_workspace', columns: ['workspace_id'])]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column]
    private int $venueId;

    #[ORM\Column(length: 255)]
    private string $guestName;

    #[ORM\Column(length: 32)]
    private string $guestPhone;

    #[ORM\Column]
    private int $peopleCount;

    #[ORM\Column]
    private \DateTimeImmutable $desiredAt;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

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

    public function getVenueId(): int
    {
        return $this->venueId;
    }

    public function setVenueId(int $venueId): void
    {
        $this->venueId = $venueId;
    }

    public function getGuestName(): string
    {
        return $this->guestName;
    }

    public function setGuestName(string $guestName): void
    {
        $this->guestName = $guestName;
    }

    public function getGuestPhone(): string
    {
        return $this->guestPhone;
    }

    public function setGuestPhone(string $guestPhone): void
    {
        $this->guestPhone = $guestPhone;
    }

    public function getPeopleCount(): int
    {
        return $this->peopleCount;
    }

    public function setPeopleCount(int $peopleCount): void
    {
        $this->peopleCount = $peopleCount;
    }

    public function getDesiredAt(): \DateTimeImmutable
    {
        return $this->desiredAt;
    }

    public function setDesiredAt(\DateTimeImmutable $desiredAt): void
    {
        $this->desiredAt = $desiredAt;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
