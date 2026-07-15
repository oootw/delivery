<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Release;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cp_core_release')]
#[ORM\UniqueConstraint(name: 'uniq_cp_release_ref', columns: ['ref'])]
class CoreReleaseRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private string $ref;

    #[ORM\Column(length: 32)]
    private string $contractVersion;

    #[ORM\Column]
    private bool $isLatest = true;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): string
    {
        return $this->ref;
    }

    public function setRef(string $ref): void
    {
        $this->ref = $ref;
    }

    public function getContractVersion(): string
    {
        return $this->contractVersion;
    }

    public function setContractVersion(string $contractVersion): void
    {
        $this->contractVersion = $contractVersion;
    }

    public function isLatest(): bool
    {
        return $this->isLatest;
    }

    public function setIsLatest(bool $isLatest): void
    {
        $this->isLatest = $isLatest;
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

