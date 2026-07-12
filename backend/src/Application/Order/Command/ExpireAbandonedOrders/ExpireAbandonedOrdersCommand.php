<?php

declare(strict_types=1);

namespace App\Application\Order\Command\ExpireAbandonedOrders;

/**
 * Истечение брошенных неоплаченных заказов: гость оформил заказ, но так и не оплатил.
 * Такой заказ навсегда держал бы слот лимитированного промокода и резерв баллов.
 */
class ExpireAbandonedOrdersCommand
{
    public function __construct(
        /** Заказы в статусе created старше стольких минут считаются брошенными. */
        public readonly int $ttlMinutes,
    ) {}
}
