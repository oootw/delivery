<?php

declare(strict_types=1);

namespace App\Application\Order\Command\CancelOrder;

use App\Application\Order\Entity\Order\OrderStatusEnum;
use App\Application\Order\Entity\Order\OrderStatusSourceEnum;
use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Pricing\OrderPricingInterface;
use App\Application\Order\Realtime\OrderRealtimeNotifierInterface;
use App\Application\Order\Rewards\OrderRewardsInterface;
use App\Application\Order\WaitTime\WaitTimeRecalculatorInterface;
use App\Shared\Transaction\TransactionInterface;

/**
 * Отмена заказа гостем. Разрешена, пока точка не приняла заказ в работу
 * (статусы created/paid). После принятия отмену делает только персонал.
 * Возврат оплаченных средств — отдельный сценарий, добавим позже.
 */
class CancelOrderHandler
{
    private const CANCELABLE_BY_CUSTOMER = [OrderStatusEnum::Created, OrderStatusEnum::Paid];

    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly OrderRealtimeNotifierInterface $realtimeNotifier,
        private readonly WaitTimeRecalculatorInterface $waitTimeRecalculator,
        private readonly OrderPricingInterface $orderPricing,
        private readonly OrderRewardsInterface $orderRewards,
        private readonly TransactionInterface $transaction,
    ) {}

    public function handle(CancelOrderCommand $command): void
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

        // Отмена, откат применённых акций и возврат баллов — атомарно.
        $this->transaction->wrap(function () use ($order): void {
            $this->orders->save($order);
            $this->orderPricing->revertApplied($order->id);
            $this->orderRewards->releaseOnCancel(
                orderId: $order->id,
                workspaceId: $order->workspaceId,
                customerId: $order->customerId,
                netPaidKopecks: $order->totalKopecks,
            );
        });

        $this->realtimeNotifier->publishStatus($order);

        // Заказ покинул очередь — пересчитываем ETA оставшихся.
        $this->waitTimeRecalculator->recalculateForVenue($order->venueId);
    }
}
