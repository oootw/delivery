<?php

declare(strict_types=1);

namespace App\Application\Customization\Entity\WorkspaceCustomModule;

/**
 * Активация клиентского модуля кастомизации на воркспейсе. Одна строка на пару
 * (воркспейс, slug модуля). Именно эти данные — а не наличие кода в src/Custom — включают
 * кастом для воркспейса: снять клиента = отключить/удалить запись, ядро не трогается.
 */
class WorkspaceCustomModule
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public string $slug,
        public bool $isEnabled,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(int $workspaceId, string $slug): self
    {
        $slug = trim($slug);

        if ($slug === '') {
            throw new \DomainException('Укажите slug модуля');
        }

        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            workspaceId: $workspaceId,
            slug: $slug,
            isEnabled: true,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function enable(): void
    {
        $this->isEnabled = true;
        $this->touch();
    }

    public function disable(): void
    {
        $this->isEnabled = false;
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
