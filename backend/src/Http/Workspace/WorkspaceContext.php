<?php

declare(strict_types=1);

namespace App\Http\Workspace;

/**
 * Контекст текущего воркспейса в рамках HTTP-запроса.
 *
 * Идентификатор воркспейса фиксируется на сервере через WORKSPACE_ID в окружении.
 * Заполняется в WorkspaceContextListener и читается в Action'ах, чтобы передать
 * workspace_id в Command/Query явным параметром.
 */
final class WorkspaceContext
{
    private ?int $workspaceId = null;

    public function bindWorkspaceId(int $workspaceId): void
    {
        $this->workspaceId = $workspaceId;
    }

    public function hasWorkspace(): bool
    {
        return $this->workspaceId !== null;
    }

    public function findWorkspaceId(): ?int
    {
        return $this->workspaceId;
    }

    public function getWorkspaceId(): int
    {
        if ($this->workspaceId === null) {
            throw new \DomainException('Воркспейс не определён для текущего запроса');
        }

        return $this->workspaceId;
    }
}
