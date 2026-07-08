<?php

declare(strict_types=1);

namespace App\Application\Order\Command\PlaceOrder;

/**
 * Результат оформления: id заказа и параметры для платёжного виджета CloudPayments
 * (первый платёж инициирует фронт, оплату подтверждает webhook).
 */
final class PlacedOrderDTO
{
    public function __construct(
        public readonly int $orderId,
        public readonly string $invoiceId,
        public readonly int $accountId,
        public readonly int $totalKopecks,
        public readonly string $amountRubles,
        public readonly string $currency,
    ) {}
}
