<?php

declare(strict_types=1);

namespace App\Application\Billing\Command\SetWorkspacePaymentSettings;

class SetWorkspacePaymentSettingsCommand
{
    /** @param array<string, string> $credentials */
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly string $provider,
        public readonly array $credentials,
        public readonly bool $isActive,
    ) {}
}
