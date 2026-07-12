<?php

declare(strict_types=1);

namespace App\Application\Customization\Entity\WorkspaceSettings;

interface WorkspaceSettingsRepositoryInterface
{
    public function save(WorkspaceSettings $settings): int;

    public function findByWorkspace(int $workspaceId): ?WorkspaceSettings;

    public function getOrCreate(int $workspaceId): WorkspaceSettings;
}
