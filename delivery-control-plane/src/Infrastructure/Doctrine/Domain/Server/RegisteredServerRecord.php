<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Server;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cp_server')]
#[ORM\UniqueConstraint(name: 'uniq_cp_server_token', columns: ['server_token'])]
#[ORM\UniqueConstraint(name: 'uniq_cp_server_owner_domain', columns: ['owner_slug', 'domain'])]
class RegisteredServerRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private string $ownerSlug;

    #[ORM\Column(length: 190)]
    private string $domain;

    #[ORM\Column]
    private int $ownerId;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column(length: 128)]
    private string $serverToken;

    #[ORM\Column(length: 128)]
    private string $coreRef;

    #[ORM\Column(length: 32)]
    private string $contractVersion;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $pinnedRef = null;

    #[ORM\Column]
    private \DateTimeImmutable $lastSeenAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnerSlug(): string
    {
        return $this->ownerSlug;
    }

    public function setOwnerSlug(string $ownerSlug): void
    {
        $this->ownerSlug = $ownerSlug;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }

    public function getWorkspaceId(): int
    {
        return $this->workspaceId;
    }

    public function setWorkspaceId(int $workspaceId): void
    {
        $this->workspaceId = $workspaceId;
    }

    public function getServerToken(): string
    {
        return $this->serverToken;
    }

    public function setServerToken(string $serverToken): void
    {
        $this->serverToken = $serverToken;
    }

    public function getCoreRef(): string
    {
        return $this->coreRef;
    }

    public function setCoreRef(string $coreRef): void
    {
        $this->coreRef = $coreRef;
    }

    public function getContractVersion(): string
    {
        return $this->contractVersion;
    }

    public function setContractVersion(string $contractVersion): void
    {
        $this->contractVersion = $contractVersion;
    }

    public function getPinnedRef(): ?string
    {
        return $this->pinnedRef;
    }

    public function setPinnedRef(?string $pinnedRef): void
    {
        $this->pinnedRef = $pinnedRef;
    }

    public function getLastSeenAt(): \DateTimeImmutable
    {
        return $this->lastSeenAt;
    }

    public function setLastSeenAt(\DateTimeImmutable $lastSeenAt): void
    {
        $this->lastSeenAt = $lastSeenAt;
    }
}

