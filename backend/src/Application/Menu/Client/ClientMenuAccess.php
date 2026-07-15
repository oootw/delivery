<?php

declare(strict_types=1);

namespace App\Application\Menu\Client;

use App\Application\Venue\Entity\Venue\Venue;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\Workspace;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;

/**
 * Доступ клиента к витрине меню: бренд определяется по workspace_id сервера,
 * членство в воркспейсе не требуется. Проверяет, что запрошенная точка принадлежит
 * этому воркспейсу — клиент бренда A не должен читать точки бренда B.
 */
final class ClientMenuAccess
{
    public function __construct(
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly VenueRepositoryInterface $venues,
    ) {}

    public function workspaceById(int $workspaceId): Workspace
    {
        $workspace = $this->workspaces->findById($workspaceId);

        if ($workspace === null) {
            throw new \DomainException('Бренд не найден');
        }

        return $workspace;
    }

    /** Точка, принадлежащая воркспейсу сервера. Иначе — ошибка доступа. */
    public function venueOfWorkspace(int $workspaceId, int $venueId): Venue
    {
        $workspace = $this->workspaceById($workspaceId);

        $venue = $this->venues->findById($venueId);

        if ($venue === null || $venue->workspaceId !== $workspace->id) {
            throw new \DomainException('Точка не найдена');
        }

        return $venue;
    }
}
