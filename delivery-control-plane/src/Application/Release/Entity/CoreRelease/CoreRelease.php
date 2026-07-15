<?php

declare(strict_types=1);

namespace App\Application\Release\Entity\CoreRelease;

final class CoreRelease
{
    private function __construct(
        public ?int $id,
        public readonly string $ref,
        public readonly string $contractVersion,
        public bool $isLatest,
        public \DateTimeImmutable $createdAt,
    ) {}

    public static function buildNew(string $ref, string $contractVersion): self
    {
        return new self(
            id: null,
            ref: $ref,
            contractVersion: $contractVersion,
            isLatest: true,
            createdAt: new \DateTimeImmutable(),
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }

    public function restoreCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}

