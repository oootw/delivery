<?php

declare(strict_types=1);

namespace App\Application\Billing\Query\GetWorkspacePaymentSettings;

/**
 * Read-model настроек оплаты. Секреты не отдаём — только провайдер, флаг активности
 * и признак, что креды заданы (для UI «настроено / требует ввода»).
 */
class WorkspacePaymentSettingsView
{
    public function __construct(
        public readonly string $provider,
        public readonly bool $isActive,
        public readonly bool $credentialsSet,
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'provider' => $this->provider,
            'is_active' => $this->isActive,
            'credentials_set' => $this->credentialsSet,
        ];
    }
}
