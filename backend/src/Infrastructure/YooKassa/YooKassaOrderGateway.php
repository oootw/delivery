<?php

declare(strict_types=1);

namespace App\Infrastructure\YooKassa;

use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentGatewayInterface;
use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentInstruction;
use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentRequest;
use App\Shared\Contract\Payment\PaymentProviderEnum;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Адаптер оплаты заказа через ЮKassa. Платёж создаётся на сервере (POST /payments,
 * Basic-авторизация shopId:secretKey, Idempotence-Key = invoiceId заказа) с типом
 * подтверждения embedded — фронт рендерит виджет ЮKassa по confirmation_token.
 * order_id/workspace_id кладём в metadata, чтобы сопоставить webhook с заказом.
 * Экземпляр с кредами воркспейса собирает WorkspaceOrderPaymentGatewayFactory.
 */
final class YooKassaOrderGateway implements OrderPaymentGatewayInterface
{
    private const PAYMENTS_PATH = '/payments';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $shopId,
        private readonly string $secretKey,
        private readonly string $apiUrl,
    ) {}

    public function createPayment(OrderPaymentRequest $request): OrderPaymentInstruction
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                rtrim($this->apiUrl, '/') . self::PAYMENTS_PATH,
                [
                    'auth_basic' => [$this->shopId, $this->secretKey],
                    'headers' => ['Idempotence-Key' => $request->invoiceId],
                    'json' => [
                        'amount' => [
                            'value' => $request->amountAsString(),
                            'currency' => $request->currency,
                        ],
                        'confirmation' => ['type' => 'embedded'],
                        'capture' => true,
                        'description' => $request->description,
                        'metadata' => [
                            'kind' => 'order',
                            'order_id' => (string) $request->orderId,
                            'workspace_id' => (string) $request->workspaceId,
                        ],
                    ],
                ],
            );

            $result = $response->toArray(throw: false);
        } catch (\Throwable $exception) {
            throw new \DomainException('ЮKassa недоступна, не удалось создать платёж');
        }

        $token = $result['confirmation']['confirmation_token'] ?? null;

        if (!is_string($token) || $token === '') {
            throw new \DomainException($result['description'] ?? 'ЮKassa отклонила создание платежа');
        }

        return new OrderPaymentInstruction(
            provider: PaymentProviderEnum::YooKassa,
            confirmationType: 'embedded',
            payload: [
                'confirmation_token' => $token,
                'payment_id' => (string) ($result['id'] ?? ''),
                'amount' => $request->amountAsString(),
                'currency' => $request->currency,
            ],
        );
    }
}
