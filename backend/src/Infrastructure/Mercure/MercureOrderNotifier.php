<?php

declare(strict_types=1);

namespace App\Infrastructure\Mercure;

use App\Application\Order\Entity\Order\Order;
use App\Application\Order\Realtime\OrderRealtimeNotifierInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

/**
 * Реалтайм-оповещения о заказе через Mercure. Гость подписывается на тему
 * «orders/{id}» и получает смену статуса и обновление времени ожидания.
 *
 * Публикация не должна ронять бизнес-операцию: если хаб недоступен, гость
 * увидит статус при следующем запросе — поэтому ошибку глушим в лог-канал.
 */
final class MercureOrderNotifier implements OrderRealtimeNotifierInterface
{
    public function __construct(
        private readonly HubInterface $hub,
    ) {}

    public function publishStatus(Order $order): void
    {
        $payload = json_encode([
            'id' => $order->id,
            'status' => $order->status->value,
            'estimated_wait_minutes' => $order->estimatedWaitMinutes,
            'updated_at' => $order->updatedAt->format(\DateTimeInterface::ATOM),
        ], JSON_THROW_ON_ERROR);

        $this->hub->publish(new Update('orders/' . $order->id, $payload));
    }
}
