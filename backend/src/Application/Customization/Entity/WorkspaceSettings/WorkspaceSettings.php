<?php

declare(strict_types=1);

namespace App\Application\Customization\Entity\WorkspaceSettings;

/**
 * Значения настроек воркспейса — одна строка на воркспейс, карта ключ→скаляр. Схема (какие
 * ключи существуют, их типы и значения по умолчанию) живёт в коде (SettingsCatalog); здесь —
 * только переопределённые значения. Ключуется на числовой workspace_id.
 */
class WorkspaceSettings
{
    /**
     * @param array<string, bool|int|string> $values
     */
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public array $values,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(int $workspaceId): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            workspaceId: $workspaceId,
            values: [],
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function get(string $key): bool|int|string|null
    {
        return $this->values[$key] ?? null;
    }

    public function set(string $key, bool|int|string $value): void
    {
        $this->values[$key] = $value;
        $this->touch();
    }

    /**
     * @param array<string, bool|int|string> $values
     */
    public function setMany(array $values): void
    {
        foreach ($values as $key => $value) {
            $this->values[$key] = $value;
        }

        $this->touch();
    }

    public function remove(string $key): void
    {
        unset($this->values[$key]);
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
