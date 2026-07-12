<?php

declare(strict_types=1);

namespace App\Shared\Contract\Payment\OrderPaymentGateway;

use App\Shared\Contract\Payment\PaymentProviderEnum;

/**
 * Нормализованная инструкция «как подтвердить оплату» для фронтенда. Провайдер и тип
 * подтверждения общие; provider-специфичные параметры лежат в payload (public_id/invoice_id
 * для виджета CloudPayments, confirmation_token для embedded-виджета ЮKassa).
 */
final class OrderPaymentInstruction
{
    /** @param array<string, mixed> $payload */
    public function __construct(
        public readonly PaymentProviderEnum $provider,
        public readonly string $confirmationType,
        public readonly array $payload,
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_merge(
            [
                'provider' => $this->provider->value,
                'confirmation_type' => $this->confirmationType,
            ],
            $this->payload,
        );
    }
}
