<?php

declare(strict_types=1);

namespace App\Application\Menu\Client;

use App\Application\Venue\Entity\Venue\Venue;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\Workspace;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;

/**
 * Доступ клиента к витрине меню: бренд определяется по slug воркспейса (из поддомена),
 * членство в воркспейсе не требуется. Проверяет, что запрошенная точка принадлежит
 * этому воркспейсу — клиент бренда A не должен читать точки бренда B.
 */
final class ClientMenuAccess
{
    public function __construct(
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly VenueRepositoryInterface $venues,
    ) {}

    public function workspaceBySlug(string $slug): Workspace
    {
        $workspace = $this->workspaces->findBySlug($slug);

        if ($workspace === null) {
            throw new \DomainException('Бренд не найден');
        }

        return $workspace;
    }

    /** Точка, принадлежащая воркспейсу этого slug. Иначе — ошибка доступа. */
    public function venueOfWorkspace(string $slug, int $venueId): Venue
    {
        $workspace = $this->workspaceBySlug($slug);

        $venue = $this->venues->findById($venueId);

        if ($venue === null || $venue->workspaceId !== $workspace->id) {
            throw new \DomainException('Точка не найдена');
        }

        return $venue;
    }
}
