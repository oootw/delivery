<?php

declare(strict_types=1);

namespace App\Application\Deployment\Entity\Deployment;

final class Deployment
{
    private function __construct(
        public ?int $id,
        public readonly string $kind,
        public readonly string $releaseRef,
        public readonly string $initiator,
        public readonly string $targetHost,
        public readonly string $status,
        public readonly \DateTimeImmutable $createdAt,
    ) {}

    public static function buildNew(
        string $kind,
        string $releaseRef,
        string $initiator,
        string $targetHost,
        string $status,
    ): self {
        return new self(
            id: null,
            kind: $kind,
            releaseRef: $releaseRef,
            initiator: $initiator,
            targetHost: $targetHost,
            status: $status,
            createdAt: new \DateTimeImmutable(),
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}

