<?php

declare(strict_types=1);

namespace App\Application\Customization\Entity\WorkspaceCustomModule;

interface WorkspaceCustomModuleRepositoryInterface
{
    public function save(WorkspaceCustomModule $module): int;

    public function findByWorkspaceAndSlug(int $workspaceId, string $slug): ?WorkspaceCustomModule;

    /**
     * @return WorkspaceCustomModule[]
     */
    public function findByWorkspace(int $workspaceId): array;

    /**
     * Slug'и включённых на воркспейсе модулей — вход для CustomModuleRegistry.
     *
     * @return list<string>
     */
    public function findEnabledSlugsByWorkspace(int $workspaceId): array;
}
