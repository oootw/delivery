<?php

declare(strict_types=1);

namespace App\Shared\Contract\Payment\OrderPaymentGateway;

/**
 * Перезапрос статуса платежа заказа у провайдера кредами воркспейса — подтверждение
 * подлинности webhook там, где нет подписи (ЮKassa). CloudPayments подтверждается
 * HMAC-подписью в своём webhook-Action, поэтому здесь не участвует.
 */
interface OrderPaymentStatusResolverInterface
{
    public function fetchStatus(int $workspaceId, string $externalPaymentId): OrderPaymentStatus;
}
