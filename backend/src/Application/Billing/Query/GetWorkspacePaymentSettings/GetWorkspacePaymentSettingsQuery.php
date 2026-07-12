<?php

declare(strict_types=1);

namespace App\Application\Billing\Query\GetWorkspacePaymentSettings;

class GetWorkspacePaymentSettingsQuery
{
    public function __construct(
        public readonly int $workspaceId,
        public readonly int $userId,
    ) {}
}
