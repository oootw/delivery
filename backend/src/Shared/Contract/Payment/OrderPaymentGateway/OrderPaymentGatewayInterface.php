<?php

declare(strict_types=1);

namespace App\Shared\Contract\Payment\OrderPaymentGateway;

/**
 * Контракт оплаты заказов. Реализации per-provider (CloudPayments, ЮKassa); конкретный
 * адаптер для воркспейса собирает OrderPaymentGatewayResolverInterface по его настройкам.
 */
interface OrderPaymentGatewayInterface
{
    public function createPayment(OrderPaymentRequest $request): OrderPaymentInstruction;
}
