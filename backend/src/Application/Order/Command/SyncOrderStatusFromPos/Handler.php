<?php

declare(strict_types=1);

namespace App\Application\Order\Command\SyncOrderStatusFromPos;

use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Entity\Order\OrderStatusEnum;
use App\Application\Order\Entity\Order\OrderStatusSourceEnum;
use App\Application\Order\Pricing\OrderPricingInterface;
use App\Application\Order\Realtime\OrderRealtimeNotifierInterface;
use App\Application\Order\Rewards\OrderRewardsInterface;
use App\Application\Order\WaitTime\WaitTimeRecalculatorInterface;

/**
 * Применение статуса заказа, пришедшего из POS-системы точки. Ожидает уже
 * приведённый к нашему словарю статус (маппинг POS → OrderStatusEnum делает
 * адаптер POS). Вызывается будущим планировщиком синхронизации с iiko/rkeeper.
 *
 * Идемпотентен: повтор того же статуса игнорируется — POS опрашивается по таймеру
 * и часто присылает неизменившийся статус.
 */
class Handler
{
    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly OrderRealtimeNotifierInterface $realtimeNotifier,
        private readonly WaitTimeRecalculatorInterface $waitTimeRecalculator,
        private readonly OrderRewardsInterface $orderRewards,
        private readonly OrderPricingInterface $orderPricing,
    ) {}

    public function handle(Command $command): void
    {
        $newStatus = OrderStatusEnum::tryFrom($command->newStatus);

        if ($newStatus === null) {
            throw new \DomainException('Неизвестный статус заказа из POS');
        }

        $order = $this->orders->findById($command->orderId);

        if ($order === null) {
            throw new \DomainException('Заказ не найден');
        }

        if ($order->status === $newStatus) {
            return;
        }

        $order->changeStatus($newStatus, OrderStatusSourceEnum::Pos);

        if ($newStatus === OrderStatusEnum::Completed) {
            $earned = $this->orderRewards->accrueOnCompleted(
                orderId: $order->id,
                workspaceId: $order->workspaceId,
                customerId: $order->customerId,
                netPaidKopecks: $order->totalKopecks,
            );
            $order->recordEarnedPoints($earned);
        }

        if ($newStatus === OrderStatusEnum::Canceled) {
            $this->orderPricing->revertApplied($order->id);
            $this->orderRewards->releaseOnCancel(
                orderId: $order->id,
                workspaceId: $order->workspaceId,
                customerId: $order->customerId,
                netPaidKopecks: $order->totalKopecks,
            );
        }

        $this->orders->save($order);

        $this->realtimeNotifier->publishStatus($order);

        $this->waitTimeRecalculator->recalculateForVenue($order->venueId);
    }
}
