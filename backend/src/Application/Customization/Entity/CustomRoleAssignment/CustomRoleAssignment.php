<?php

declare(strict_types=1);

namespace App\Application\Customization\Entity\CustomRoleAssignment;

/**
 * Назначение кастомной роли участнику воркспейса. Одна строка на тройку (воркспейс,
 * пользователь, ключ роли). Хранит только ключ роли (строку) — сама роль объявляется активным
 * модулем; если модуль неактивен или роль не объявлена, назначение не действует (проверяет
 * CustomAccess). Ключуется на числовые workspace_id/user_id — не зависит от slug.
 */
class CustomRoleAssignment
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public int $userId,
        public string $roleKey,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(int $workspaceId, int $userId, string $roleKey): self
    {
        $roleKey = trim($roleKey);

        if ($roleKey === '') {
            throw new \DomainException('Укажите ключ роли');
        }

        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            workspaceId: $workspaceId,
            userId: $userId,
            roleKey: $roleKey,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
