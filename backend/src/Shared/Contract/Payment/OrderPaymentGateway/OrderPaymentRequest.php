<?php

declare(strict_types=1);

namespace App\Shared\Contract\Payment\OrderPaymentGateway;

/**
 * Запрос на инициацию оплаты заказа. Провайдер-независимый — адаптер сам решает,
 * как подтверждать оплату (виджет CloudPayments / embedded-токен ЮKassa).
 */
final class OrderPaymentRequest
{
    public function __construct(
        public readonly int $workspaceId,
        public readonly int $orderId,
        public readonly string $invoiceId,
        public readonly int $customerId,
        public readonly int $amountKopecks,
        public readonly string $currency,
        public readonly string $description,
    ) {}

    /** Сумма в основной валюте строкой «500.00» (формат обоих провайдеров). */
    public function amountAsString(): string
    {
        return number_format($this->amountKopecks / 100, 2, '.', '');
    }
}
