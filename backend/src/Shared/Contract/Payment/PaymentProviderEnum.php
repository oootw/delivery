<?php

declare(strict_types=1);

namespace App\Shared\Contract\Payment;

enum PaymentProviderEnum: string
{
    case CloudPayments = 'cloudpayments';
    case YooKassa = 'yookassa';

    /**
     * Обязательные ключи кредов мерчант-аккаунта для провайдера.
     *
     * @return list<string>
     */
    public function requiredCredentialKeys(): array
    {
        return match ($this) {
            self::CloudPayments => ['public_id', 'api_secret'],
            self::YooKassa => ['shop_id', 'secret_key'],
        };
    }
}
