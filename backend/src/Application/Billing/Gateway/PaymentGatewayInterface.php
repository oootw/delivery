<?php

declare(strict_types=1);

namespace App\Application\Billing\Gateway;

/**
 * Порт платёжного шлюза. Реализация — в Infrastructure (CloudPayments).
 *
 * Первый платёж и токенизация карты выполняются виджетом на фронтенде;
 * бэкенд реагирует на webhook'и и умеет отменять рекуррентную подписку.
 * В M5 через этот же порт добавится оплата заказов гостями.
 */
interface PaymentGatewayInterface
{
    public function verifyWebhookSignature(string $rawBody, ?string $signature): bool;

    public function cancelSubscription(string $externalSubscriptionId): void;
}
