<?php

declare(strict_types=1);

namespace App\Application\Workspace\Service;

use App\Application\License\Contract\LicenseProviderInterface;
use App\Application\License\Enum\LicenseStatusEnum;
use App\Application\Workspace\Entity\Membership\MembershipRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\Workspace;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;

/**
 * Проверки доступа к воркспейсу. Владелец управляет воркспейсом и точками;
 * любой участник (владелец или сотрудник) может просматривать данные воркспейса.
 * Право владельца в системе определяется статусом лицензии control-plane.
 */
final class WorkspaceAccess
{
    public function __construct(
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly MembershipRepositoryInterface $memberships,
        private readonly LicenseProviderInterface $licenseProvider,
    ) {}

    /**
     * Владельческий доступ для мутаций: проверяет владение И активную лицензию.
     */
    public function getOwnedWorkspace(int $workspaceId, int $userId): Workspace
    {
        $workspace = $this->workspaces->findById($workspaceId);

        if ($workspace === null) {
            throw new \DomainException('Воркспейс не найден');
        }

        if ($workspace->ownerId !== $userId) {
            throw new \DomainException('Недостаточно прав');
        }

        $this->requireActiveLicense();

        return $workspace;
    }

    public function requireMember(int $workspaceId, int $userId): void
    {
        $membership = $this->memberships->findByWorkspaceAndUser($workspaceId, $userId);

        if ($membership === null) {
            throw new \DomainException('Нет доступа к воркспейсу');
        }
    }

    /**
     * Работает ли воркспейс: у его владельца есть активная лицензия. Для гостевого
     * пути (приём заказов) — воркспейс с неактивной лицензией заказы не принимает.
     */
    public function requireActiveWorkspace(int $workspaceId): void
    {
        $workspace = $this->workspaces->findById($workspaceId);

        if ($workspace === null) {
            throw new \DomainException('Воркспейс не найден');
        }

        $this->requireActiveLicense();
    }

    private function requireActiveLicense(): void
    {
        try {
            $snapshot = $this->licenseProvider->getSnapshot();
        } catch (\Throwable) {
            throw new \DomainException('Подписка воркспейса неактивна');
        }

        if ($snapshot->status !== LicenseStatusEnum::Active) {
            throw new \DomainException('Подписка воркспейса неактивна');
        }
    }
}
