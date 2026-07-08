<?php

declare(strict_types=1);

namespace App\Http\Workspace;

/**
 * Контекст текущего воркспейса в рамках HTTP-запроса.
 *
 * Slug определяется из поддомена (slug.app.com), в dev — из заголовка X-Workspace-Slug.
 * Заполняется в WorkspaceContextListener и читается в Action'ах, чтобы передать
 * идентификатор воркспейса в Command/Query явным параметром.
 *
 * Привязка slug -> workspaceId появится вместе с WorkspaceRepository (веха M2).
 */
final class WorkspaceContext
{
    private ?string $slug = null;

    public function bindSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function hasWorkspace(): bool
    {
        return $this->slug !== null;
    }

    public function findSlug(): ?string
    {
        return $this->slug;
    }

    public function getSlug(): string
    {
        if ($this->slug === null) {
            throw new \DomainException('Воркспейс не определён для текущего запроса');
        }

        return $this->slug;
    }
}
