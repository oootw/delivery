<?php

declare(strict_types=1);

namespace App\Infrastructure\Payment;

use App\Application\Billing\Entity\WorkspacePaymentSettings\WorkspacePaymentSettingsRepositoryInterface;
use App\Infrastructure\CloudPayments\CloudPaymentsOrderGateway;
use App\Infrastructure\YooKassa\YooKassaOrderGateway;
use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentGatewayInterface;
use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentGatewayResolverInterface;
use App\Shared\Contract\Payment\PaymentProviderEnum;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Собирает платёжный шлюз заказа под конкретный воркспейс: читает его настройки
 * (провайдер + расшифрованные креды) и создаёт адаптер. Воркспейс без активной настройки —
 * платформенный CloudPayments (сохраняет поведение, бывшее до per-workspace выбора).
 */
final class WorkspaceOrderPaymentGatewayFactory implements OrderPaymentGatewayResolverInterface
{
    public function __construct(
        private readonly WorkspacePaymentSettingsRepositoryInterface $paymentSettings,
        private readonly HttpClientInterface $httpClient,
        private readonly string $platformCloudPaymentsPublicId,
        private readonly string $yooKassaApiUrl,
    ) {}

    public function forWorkspace(int $workspaceId): OrderPaymentGatewayInterface
    {
        $settings = $this->paymentSettings->findByWorkspace($workspaceId);

        if ($settings === null || !$settings->isActive) {
            return new CloudPaymentsOrderGateway($this->platformCloudPaymentsPublicId);
        }

        return match ($settings->provider) {
            PaymentProviderEnum::CloudPayments => new CloudPaymentsOrderGateway(
                $settings->credentials['public_id'],
            ),
            PaymentProviderEnum::YooKassa => new YooKassaOrderGateway(
                httpClient: $this->httpClient,
                shopId: $settings->credentials['shop_id'],
                secretKey: $settings->credentials['secret_key'],
                apiUrl: $this->yooKassaApiUrl,
            ),
        };
    }
}
