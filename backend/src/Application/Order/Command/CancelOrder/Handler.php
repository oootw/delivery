<?php

declare(strict_types=1);

namespace App\Application\Order\Command\CancelOrder;

use App\Application\Order\Entity\Order\OrderStatusEnum;
use App\Application\Order\Entity\Order\OrderStatusSourceEnum;
use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Realtime\OrderRealtimeNotifierInterface;
use App\Application\Order\WaitTime\WaitTimeRecalculatorInterface;

/**
 * Отмена заказа гостем. Разрешена, пока точка не приняла заказ в работу
 * (статусы created/paid). После принятия отмену делает только персонал.
 * Возврат оплаченных средств — отдельный сценарий, добавим позже.
 */
class Handler
{
    private const CANCELABLE_BY_CUSTOMER = [OrderStatusEnum::Created, OrderStatusEnum::Paid];

    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly OrderRealtimeNotifierInterface $realtimeNotifier,
        private readonly WaitTimeRecalculatorInterface $waitTimeRecalculator,
    ) {}

    public function handle(Command $command): void
    {
        $order = $this->orders->findById($command->orderId);

        if ($order === null) {
            throw new \DomainException('Заказ не найден');
        }

        if ($order->customerId !== $command->customerId) {
            throw new \DomainException('Это не ваш заказ');
        }

        if (!in_array($order->status, self::CANCELABLE_BY_CUSTOMER, true)) {
            throw new \DomainException('Заказ уже готовится, отмену оформит точка');
        }

        $order->cancel(OrderStatusSourceEnum::Customer);

        $this->orders->save($order);

        $this->realtimeNotifier->publishStatus($order);

        // Заказ покинул очередь — пересчитываем ETA оставшихся.
        $this->waitTimeRecalculator->recalculateForVenue($order->venueId);
    }
}
