<?php

declare(strict_types=1);

namespace App\Infrastructure\YooKassa;

use App\Application\Billing\Entity\WorkspacePaymentSettings\WorkspacePaymentSettingsRepositoryInterface;
use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentStatus;
use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentStatusResolverInterface;
use App\Shared\Contract\Payment\PaymentProviderEnum;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Перезапрашивает платёж у ЮKassa (GET /payments/{id}) кредами воркспейса, чтобы
 * подтвердить подлинность webhook (у ЮKassa нет подписи) и получить авторитетные
 * статус/сумму/metadata.order_id. Провайдер воркспейса обязан быть ЮKassa.
 */
final class YooKassaPaymentStatusResolver implements OrderPaymentStatusResolverInterface
{
    private const PAYMENTS_PATH = '/payments/';

    public function __construct(
        private readonly WorkspacePaymentSettingsRepositoryInterface $paymentSettings,
        private readonly HttpClientInterface $httpClient,
        private readonly string $yooKassaApiUrl,
    ) {}

    public function fetchStatus(int $workspaceId, string $externalPaymentId): OrderPaymentStatus
    {
        $settings = $this->paymentSettings->findByWorkspace($workspaceId);

        if ($settings === null || !$settings->isActive || $settings->provider !== PaymentProviderEnum::YooKassa) {
            throw new \DomainException('Для воркспейса не настроена оплата через ЮKassa');
        }

        try {
            $response = $this->httpClient->request(
                'GET',
                rtrim($this->yooKassaApiUrl, '/') . self::PAYMENTS_PATH . rawurlencode($externalPaymentId),
                [
                    'auth_basic' => [$settings->credentials['shop_id'], $settings->credentials['secret_key']],
                ],
            );

            $result = $response->toArray(throw: false);
        } catch (\Throwable $exception) {
            throw new \RuntimeException('ЮKassa недоступна, статус платежа не получен');
        }

        $orderIdRaw = $result['metadata']['order_id'] ?? null;
        $amountValue = $result['amount']['value'] ?? null;

        return new OrderPaymentStatus(
            isSucceeded: ($result['status'] ?? null) === 'succeeded',
            orderId: $orderIdRaw !== null ? (int) $orderIdRaw : null,
            amountKopecks: $amountValue !== null ? (int) round(((float) $amountValue) * 100) : 0,
        );
    }
}
