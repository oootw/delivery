<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\StartSubscription;

/**
 * Данные, которые фронтенд передаёт в виджет CloudPayments для первого платежа.
 * amountRubles — сумма в рублях строкой (виджет ожидает сумму в единицах валюты).
 */
class StartedSubscriptionDTO
{
    public function __construct(
        public readonly int $subscriptionId,
        public readonly string $invoiceId,
        public readonly int $accountId,
        public readonly string $tarifCode,
        public readonly string $tarifName,
        public readonly int $priceKopecks,
        public readonly string $amountRubles,
        public readonly string $currency,
    ) {}
}
