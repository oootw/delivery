<?php

declare(strict_types=1);

namespace App\Application\Order\Entity\Order;

/**
 * Жизненный цикл заказа.
 *
 * Created  — оформлен, ждёт онлайн-оплаты.
 * Paid     — оплата подтверждена webhook'ом CloudPayments, заказ виден точке.
 * Accepted — точка приняла заказ в работу.
 * Cooking  — готовится на кухне.
 * Ready    — готов (к выдаче — самовывоз, или к передаче курьеру — доставка).
 * OnTheWay — курьер везёт заказ (только доставка).
 * Completed — выдан/доставлен.
 * Canceled — отменён.
 */
enum OrderStatusEnum: string
{
    case Created = 'created';
    case Paid = 'paid';
    case Accepted = 'accepted';
    case Cooking = 'cooking';
    case Ready = 'ready';
    case OnTheWay = 'on_the_way';
    case Completed = 'completed';
    case Canceled = 'canceled';

    public function isTerminal(): bool
    {
        return $this === self::Completed || $this === self::Canceled;
    }
}
