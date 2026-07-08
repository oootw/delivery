<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\PosIntegration;

use App\Application\PosIntegration\Entity\PosConnection\PosConnectionStatusEnum;
use App\Application\PosIntegration\Entity\PosConnection\PosSystemEnum;
use App\Infrastructure\Doctrine\Domain\PosIntegration\PosConnectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosConnectionRepository::class)]
#[ORM\Table(name: 'pos_connection')]
#[ORM\UniqueConstraint(name: 'uniq_pos_connection_venue', columns: ['venue_id'])]
class PosConnection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $venueId;

    #[ORM\Column(enumType: PosSystemEnum::class)]
    private PosSystemEnum $posSystem;

    /** Зашифрованный apiLogin (см. SecretCipher). */
    #[ORM\Column(type: 'text')]
    private string $apiLoginEncrypted;

    #[ORM\Column(length: 255)]
    private string $organizationId;

    #[ORM\Column(length: 255)]
    private string $externalMenuId;

    #[ORM\Column(enumType: PosConnectionStatusEnum::class)]
    private PosConnectionStatusEnum $status;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastSyncedAt = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $lastError = null;

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

    public function getPosSystem(): PosSystemEnum
    {
        return $this->posSystem;
    }

    public function setPosSystem(PosSystemEnum $posSystem): void
    {
        $this->posSystem = $posSystem;
    }

    public function getApiLoginEncrypted(): string
    {
        return $this->apiLoginEncrypted;
    }

    public function setApiLoginEncrypted(string $apiLoginEncrypted): void
    {
        $this->apiLoginEncrypted = $apiLoginEncrypted;
    }

    public function getOrganizationId(): string
    {
        return $this->organizationId;
    }

    public function setOrganizationId(string $organizationId): void
    {
        $this->organizationId = $organizationId;
    }

    public function getExternalMenuId(): string
    {
        return $this->externalMenuId;
    }

    public function setExternalMenuId(string $externalMenuId): void
    {
        $this->externalMenuId = $externalMenuId;
    }

    public function getStatus(): PosConnectionStatusEnum
    {
        return $this->status;
    }

    public function setStatus(PosConnectionStatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getLastSyncedAt(): ?\DateTimeImmutable
    {
        return $this->lastSyncedAt;
    }

    public function setLastSyncedAt(?\DateTimeImmutable $lastSyncedAt): void
    {
        $this->lastSyncedAt = $lastSyncedAt;
    }

    public function getLastError(): ?string
    {
        return $this->lastError;
    }

    public function setLastError(?string $lastError): void
    {
        $this->lastError = $lastError;
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
