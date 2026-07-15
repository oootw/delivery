<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Subscription;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cp_owner_subscription')]
#[ORM\UniqueConstraint(name: 'uniq_cp_owner_subscription_owner', columns: ['owner_id'])]
class OwnerSubscriptionRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $ownerId;

    #[ORM\Column(length: 32)]
    private string $tarifCode;

    #[ORM\Column(length: 32)]
    private string $status;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $validUntil = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }

    public function getTarifCode(): string
    {
        return $this->tarifCode;
    }

    public function setTarifCode(string $tarifCode): void
    {
        $this->tarifCode = $tarifCode;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getValidUntil(): ?\DateTimeImmutable
    {
        return $this->validUntil;
    }

    public function setValidUntil(?\DateTimeImmutable $validUntil): void
    {
        $this->validUntil = $validUntil;
    }
}

