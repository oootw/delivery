<?php

declare(strict_types=1);

namespace App\Application\Order\Command\ChangeOrderStatus;

use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Entity\Order\OrderStatusEnum;
use App\Application\Order\Entity\Order\OrderStatusSourceEnum;
use App\Application\Order\Pricing\OrderPricingInterface;
use App\Application\Order\Realtime\OrderRealtimeNotifierInterface;
use App\Application\Order\Rewards\OrderRewardsInterface;
use App\Application\Order\WaitTime\WaitTimeRecalculatorInterface;
use App\Application\Workspace\Service\WorkspaceAccess;
use App\Shared\Transaction\TransactionInterface;

/**
 * Ручная смена статуса заказа персоналом точки (владелец или сотрудник).
 * Допустимость перехода проверяет сам заказ; гость получает уведомление realtime.
 */
class ChangeOrderStatusHandler
{
    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly OrderRealtimeNotifierInterface $realtimeNotifier,
        private readonly WaitTimeRecalculatorInterface $waitTimeRecalculator,
        private readonly OrderRewardsInterface $orderRewards,
        private readonly OrderPricingInterface $orderPricing,
        private readonly TransactionInterface $transaction,
    ) {}

    public function handle(ChangeOrderStatusCommand $command): void
    {
        $newStatus = OrderStatusEnum::tryFrom($command->newStatus);

        if ($newStatus === null) {
            throw new \DomainException('Неизвестный статус заказа');
        }

        $order = $this->orders->findById($command->orderId);

        if ($order === null) {
            throw new \DomainException('Заказ не найден');
        }

        $this->workspaceAccess->requireMember(
            workspaceId: $order->workspaceId,
            userId: $command->actingUserId,
        );

        // Проверка перехода — до записей (бросит до любых побочных эффектов).
        $order->changeStatus($newStatus, OrderStatusSourceEnum::Staff);

        // Начисление/откат баллов и скидок вместе с сохранением заказа — атомарно:
        // иначе при сбое между ними возможно двойное начисление при повторе.
        $this->transaction->wrap(function () use ($order, $newStatus): void {
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
        });

        $this->realtimeNotifier->publishStatus($order);

        // Изменилась нагрузка кухни — обновляем ETA всех активных заказов точки.
        $this->waitTimeRecalculator->recalculateForVenue($order->venueId);
    }
}
