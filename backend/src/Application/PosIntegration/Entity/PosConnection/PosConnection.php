<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Entity\PosConnection;

/**
 * Подключение точки к POS-системе (iiko/rkeeper).
 *
 * apiLogin — секрет доступа к API POS; в БД хранится в зашифрованном виде,
 * в доменной модели присутствует в открытом виде для вызова провайдера.
 */
class PosConnection
{
    public function __construct(
        public ?int $id,
        public int $venueId,
        public PosSystemEnum $posSystem,
        public string $apiLogin,
        public string $organizationId,
        public string $externalMenuId,
        public PosConnectionStatusEnum $status,
        public ?\DateTimeImmutable $lastSyncedAt,
        public ?string $lastError,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(
        int $venueId,
        PosSystemEnum $posSystem,
        string $apiLogin,
        string $organizationId,
        string $externalMenuId,
    ): self {
        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            venueId: $venueId,
            posSystem: $posSystem,
            apiLogin: $apiLogin,
            organizationId: $organizationId,
            externalMenuId: $externalMenuId,
            status: PosConnectionStatusEnum::Pending,
            lastSyncedAt: null,
            lastError: null,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function reconfigure(string $apiLogin, string $organizationId, string $externalMenuId): void
    {
        $this->apiLogin = $apiLogin;
        $this->organizationId = $organizationId;
        $this->externalMenuId = $externalMenuId;
        $this->status = PosConnectionStatusEnum::Pending;
        $this->lastError = null;
        $this->touch();
    }

    public function markSynced(): void
    {
        $this->status = PosConnectionStatusEnum::Connected;
        $this->lastSyncedAt = new \DateTimeImmutable();
        $this->lastError = null;
        $this->touch();
    }

    public function markFailed(string $error): void
    {
        $this->status = PosConnectionStatusEnum::Error;
        $this->lastError = $error;
        $this->touch();
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }

    private function touch(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
