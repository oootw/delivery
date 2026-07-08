<?php

declare(strict_types=1);

namespace App\Application\Order\Realtime;

use App\Application\Order\Entity\Order\Order;

/**
 * Порт реалтайм-оповещений о заказе. Реализация (Mercure) — в Infrastructure.
 * Гость подписывается на тему своего заказа и получает смену статуса и ETA
 * без опроса сервера.
 */
interface OrderRealtimeNotifierInterface
{
    public function publishStatus(Order $order): void;
}
