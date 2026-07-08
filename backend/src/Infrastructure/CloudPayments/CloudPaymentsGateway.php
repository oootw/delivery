<?php

declare(strict_types=1);

namespace App\Infrastructure\CloudPayments;

use App\Application\Billing\Gateway\PaymentGatewayInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Адаптер платёжного шлюза CloudPayments.
 *
 * Webhook'и подписываются HMAC-SHA256 от «сырого» тела запроса на секрете API,
 * результат в base64 приходит в заголовке Content-HMAC.
 * Отмена рекуррентной подписки — POST /subscriptions/cancel с Basic-авторизацией
 * (public id : api secret).
 */
final class CloudPaymentsGateway implements PaymentGatewayInterface
{
    private const CANCEL_SUBSCRIPTION_PATH = '/subscriptions/cancel';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $publicId,
        private readonly string $apiSecret,
        private readonly string $apiUrl,
    ) {}

    public function verifyWebhookSignature(string $rawBody, ?string $signature): bool
    {
        if ($signature === null || $signature === '') {
            return false;
        }

        $expected = base64_encode(hash_hmac('sha256', $rawBody, $this->apiSecret, true));

        return hash_equals($expected, $signature);
    }

    public function cancelSubscription(string $externalSubscriptionId): void
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->apiUrl . self::CANCEL_SUBSCRIPTION_PATH,
                [
                    'auth_basic' => [$this->publicId, $this->apiSecret],
                    'json' => ['Id' => $externalSubscriptionId],
                ],
            );

            $result = $response->toArray(throw: false);
        } catch (\Throwable $exception) {
            throw new \DomainException('CloudPayments недоступен, отмена подписки не выполнена');
        }

        if (($result['Success'] ?? false) !== true) {
            throw new \DomainException($result['Message'] ?? 'CloudPayments отклонил отмену подписки');
        }
    }
}
