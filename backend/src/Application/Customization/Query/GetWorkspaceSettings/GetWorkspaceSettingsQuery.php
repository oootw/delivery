<?php

declare(strict_types=1);

namespace App\Application\Customization\Query\GetWorkspaceSettings;

class GetWorkspaceSettingsQuery
{
    public function __construct(
        public readonly int $userId,
        public readonly int $workspaceId,
    ) {}
}
