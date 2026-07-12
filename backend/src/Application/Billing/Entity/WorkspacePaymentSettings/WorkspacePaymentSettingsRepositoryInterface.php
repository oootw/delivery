<?php

declare(strict_types=1);

namespace App\Application\Billing\Entity\WorkspacePaymentSettings;

interface WorkspacePaymentSettingsRepositoryInterface
{
    public function findByWorkspace(int $workspaceId): ?WorkspacePaymentSettings;

    public function save(WorkspacePaymentSettings $settings): int;
}
