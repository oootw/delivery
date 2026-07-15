<?php

declare(strict_types=1);

namespace App\Application\Customization\Access;

use App\Application\Customization\Entity\CustomRoleAssignment\CustomRoleAssignmentRepositoryInterface;
use App\Application\Customization\Registry\CustomModuleRegistry;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;

/**
 * Проверки доступа к кастомной функциональности. Дополняет WorkspaceAccess (Owner/Staff)
 * ролями клиентских модулей.
 *
 * Роль действует, только если: (1) её объявляет активный на воркспейсе модуль и (2) она
 * назначена участнику. Владелец воркспейса неявно имеет все роли активных модулей. Всё
 * ключуется на числовые id — устойчиво к смене любых slug (см. previousSlugs в реестре).
 */
final class CustomAccess
{
    public function __construct(
        private readonly CustomModuleRegistry $modules,
        private readonly CustomRoleAssignmentRepositoryInterface $assignments,
        private readonly WorkspaceRepositoryInterface $workspaces,
    ) {}

    /** Активен ли модуль на сервере (иначе его эндпоинты не должны существовать → 404). */
    public function isModuleActive(int $workspaceId, string $slug): bool
    {
        return $this->modules->has($slug);
    }

    public function assertModuleActive(int $workspaceId, string $slug): void
    {
        if (!$this->isModuleActive($workspaceId, $slug)) {
            throw new \DomainException('Модуль не подключён');
        }
    }

    /** Объявлена ли роль каким-либо активным на сервере модулем. */
    public function roleIsAvailable(int $workspaceId, string $roleKey): bool
    {
        return $this->isDeclaredByActiveModule($workspaceId, $roleKey);
    }

    public function assertRoleIsAvailable(int $workspaceId, string $roleKey): void
    {
        if (!$this->roleIsAvailable($workspaceId, $roleKey)) {
            throw new \DomainException('Роль недоступна: модуль не подключён или роль не объявлена');
        }
    }

    public function hasRole(int $workspaceId, int $userId, string $roleKey): bool
    {
        if (!$this->isDeclaredByActiveModule($workspaceId, $roleKey)) {
            return false;
        }

        if ($this->isOwner($workspaceId, $userId)) {
            return true;
        }

        return in_array($roleKey, $this->assignments->roleKeysFor($workspaceId, $userId), true);
    }

    public function assertRole(int $workspaceId, int $userId, string $roleKey): void
    {
        if (!$this->hasRole($workspaceId, $userId, $roleKey)) {
            throw new \DomainException('Недостаточно прав');
        }
    }

    private function isDeclaredByActiveModule(int $workspaceId, string $roleKey): bool
    {
        foreach ($this->modules->all() as $module) {
            foreach ($module->roles() as $role) {
                if ($role->key === $roleKey) {
                    return true;
                }
            }
        }

        return false;
    }

    private function isOwner(int $workspaceId, int $userId): bool
    {
        return $this->workspaces->findById($workspaceId)?->ownerId === $userId;
    }
}
