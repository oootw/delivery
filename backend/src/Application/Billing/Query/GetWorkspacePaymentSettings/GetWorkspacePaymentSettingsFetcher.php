<?php

declare(strict_types=1);

namespace App\Application\Billing\Query\GetWorkspacePaymentSettings;

use App\Application\Billing\Entity\WorkspacePaymentSettings\WorkspacePaymentSettingsRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

class GetWorkspacePaymentSettingsFetcher
{
    public function __construct(
        private readonly WorkspacePaymentSettingsRepositoryInterface $paymentSettings,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function fetch(GetWorkspacePaymentSettingsQuery $query): ?WorkspacePaymentSettingsView
    {
        $this->workspaceAccess->requireMember(
            workspaceId: $query->workspaceId,
            userId: $query->userId,
        );

        $settings = $this->paymentSettings->findByWorkspace($query->workspaceId);

        if ($settings === null) {
            return null;
        }

        return new WorkspacePaymentSettingsView(
            provider: $settings->provider->value,
            isActive: $settings->isActive,
            credentialsSet: $settings->credentials !== [],
        );
    }
}
