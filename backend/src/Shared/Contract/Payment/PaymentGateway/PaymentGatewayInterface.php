<?php

declare(strict_types=1);

namespace App\Shared\Contract\Payment\PaymentGateway;

/**
 * Провайдер-независимый контракт платёжного шлюза. Реализации — в Infrastructure
 * (CloudPayments, YooKassa). Провайдер оплаты заказов выбирается на уровне воркспейса
 * (см. Billing\Entity\WorkspacePaymentSettings); подписки владельца всегда идут через
 * платформенный CloudPayments.
 */
interface PaymentGatewayInterface
{
    public function verifyWebhookSignature(string $rawBody, ?string $signature): bool;

    public function cancelSubscription(string $externalSubscriptionId): void;
}
