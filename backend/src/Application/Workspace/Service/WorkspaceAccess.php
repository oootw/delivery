<?php

declare(strict_types=1);

namespace App\Application\Workspace\Service;

use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;
use App\Application\Workspace\Entity\Membership\MembershipRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\Workspace;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;

/**
 * Проверки доступа к воркспейсу. Владелец управляет воркспейсом и точками;
 * любой участник (владелец или сотрудник) может просматривать данные воркспейса.
 * Право владельца в системе = наличие активной подписки, поэтому мутации требуют её.
 */
final class WorkspaceAccess
{
    public function __construct(
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly MembershipRepositoryInterface $memberships,
        private readonly SubscriptionRepositoryInterface $subscriptions,
    ) {}

    /**
     * Владельческий доступ для мутаций: проверяет владение И активную подписку.
     * Без подписки (past_due/canceled) владелец не может менять точки/меню/промо.
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

        $this->requireActiveSubscription($workspace->ownerId);

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
     * Работает ли воркспейс: у его владельца есть активная подписка. Для гостевого
     * пути (приём заказов) — воркспейс с неоплаченной подпиской заказы не принимает.
     */
    public function requireActiveWorkspace(int $workspaceId): void
    {
        $workspace = $this->workspaces->findById($workspaceId);

        if ($workspace === null) {
            throw new \DomainException('Воркспейс не найден');
        }

        $this->requireActiveSubscription($workspace->ownerId);
    }

    private function requireActiveSubscription(int $ownerId): void
    {
        if ($this->subscriptions->findActiveByUser($ownerId) === null) {
            throw new \DomainException('Подписка воркспейса неактивна');
        }
    }
}
