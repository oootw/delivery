<?php

declare(strict_types=1);

namespace App\Application\Customization\Entity\WorkspaceFeatureGrant;

use App\Shared\Enum\Feature\FeatureCodeEnum;

/**
 * Точечная выдача возможности (фичи) конкретному воркспейсу поверх тарифа — путь монетизации
 * «доплатил → включили». Одна строка на пару (воркспейс, фича). Ключуется на числовой
 * workspace_id и код фичи, поэтому не зависит ни от slug воркспейса, ни от slug модуля.
 */
class WorkspaceFeatureGrant
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public FeatureCodeEnum $feature,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(int $workspaceId, FeatureCodeEnum $feature): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            workspaceId: $workspaceId,
            feature: $feature,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
