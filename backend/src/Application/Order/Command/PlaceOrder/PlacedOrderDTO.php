<?php

declare(strict_types=1);

namespace App\Application\Order\Command\PlaceOrder;

use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentInstruction;

/**
 * Результат оформления: id заказа и инструкция оплаты для фронтенда (виджет CloudPayments
 * или embedded-виджет ЮKassa — зависит от провайдера воркспейса). Если итог к оплате равен
 * нулю (гость погасил всё баллами или 100% промо), заказ проводится на сервере сразу —
 * paymentRequired = false, инструкция оплаты не нужна (paymentInstruction = null).
 */
final class PlacedOrderDTO
{
    public function __construct(
        public readonly int $orderId,
        public readonly bool $paymentRequired,
        public readonly ?OrderPaymentInstruction $paymentInstruction,
    ) {}
}
