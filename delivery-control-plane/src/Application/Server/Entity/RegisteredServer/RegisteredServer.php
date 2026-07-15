<?php

declare(strict_types=1);

namespace App\Application\Server\Entity\RegisteredServer;

final class RegisteredServer
{
    private function __construct(
        public ?int $id,
        public readonly string $ownerSlug,
        public readonly string $domain,
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly string $serverToken,
        public string $coreRef,
        public string $contractVersion,
        public ?string $pinnedRef,
        public \DateTimeImmutable $lastSeenAt,
    ) {}

    public static function buildNew(
        string $ownerSlug,
        string $domain,
        int $ownerId,
        int $workspaceId,
        string $serverToken,
        string $coreRef,
        string $contractVersion,
    ): self {
        return new self(
            id: null,
            ownerSlug: $ownerSlug,
            domain: $domain,
            ownerId: $ownerId,
            workspaceId: $workspaceId,
            serverToken: $serverToken,
            coreRef: $coreRef,
            contractVersion: $contractVersion,
            pinnedRef: null,
            lastSeenAt: new \DateTimeImmutable(),
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }

    public function markSeen(string $coreRef, string $contractVersion): void
    {
        $this->coreRef = $coreRef;
        $this->contractVersion = $contractVersion;
        $this->lastSeenAt = new \DateTimeImmutable();
    }

    public function pinTo(string $coreRef): void
    {
        $this->pinnedRef = $coreRef;
    }

    public function unpin(): void
    {
        $this->pinnedRef = null;
    }
}

