<?php

declare(strict_types=1);

namespace App\Application\Billing\Command\SetWorkspacePaymentSettings;

use App\Application\Billing\Entity\WorkspacePaymentSettings\WorkspacePaymentSettings;
use App\Application\Billing\Entity\WorkspacePaymentSettings\WorkspacePaymentSettingsRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;
use App\Shared\Contract\Payment\PaymentProviderEnum;

/**
 * Настройка провайдера оплаты заказов воркспейса владельцем. Настройка одна на воркспейс —
 * создаётся при первом сохранении, дальше обновляется.
 */
class SetWorkspacePaymentSettingsHandler
{
    public function __construct(
        private readonly WorkspacePaymentSettingsRepositoryInterface $paymentSettings,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(SetWorkspacePaymentSettingsCommand $command): void
    {
        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $command->workspaceId,
            userId: $command->ownerId,
        );

        $provider = PaymentProviderEnum::tryFrom($command->provider)
            ?? throw new \DomainException('Неизвестный платёжный провайдер');

        $credentials = $this->onlyRequiredCredentials($provider, $command->credentials);

        $settings = $this->paymentSettings->findByWorkspace($command->workspaceId)
            ?? WorkspacePaymentSettings::buildNew($command->workspaceId);

        $settings->configure(
            provider: $provider,
            credentials: $credentials,
            isActive: $command->isActive,
        );

        $this->paymentSettings->save($settings);
    }

    /**
     * @param array<string, string> $credentials
     * @return array<string, string>
     */
    private function onlyRequiredCredentials(PaymentProviderEnum $provider, array $credentials): array
    {
        $result = [];

        foreach ($provider->requiredCredentialKeys() as $key) {
            $value = $credentials[$key] ?? '';

            if (!is_string($value) || trim($value) === '') {
                throw new \DomainException(sprintf('Не указан обязательный параметр оплаты: %s', $key));
            }

            $result[$key] = trim($value);
        }

        return $result;
    }
}
