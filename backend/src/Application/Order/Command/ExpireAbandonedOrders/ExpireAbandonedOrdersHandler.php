<?php

declare(strict_types=1);

namespace App\Application\Order\Command\ExpireAbandonedOrders;

use App\Application\Order\Entity\Order\Order;
use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Entity\Order\OrderStatusSourceEnum;
use App\Application\Order\Pricing\OrderPricingInterface;
use App\Application\Order\Realtime\OrderRealtimeNotifierInterface;
use App\Application\Order\Rewards\OrderRewardsInterface;
use App\Application\Order\WaitTime\WaitTimeRecalculatorInterface;
use App\Shared\Transaction\TransactionInterface;

/**
 * Отменяет брошенные неоплаченные заказы (created старше TTL), освобождая занятые ими
 * ресурсы: слот лимитированного промокода (revertApplied) и резерв баллов (releaseOnCancel).
 * Запускается кроном. Возвращает число истёкших заказов.
 */
class ExpireAbandonedOrdersHandler
{
    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly OrderRealtimeNotifierInterface $realtimeNotifier,
        private readonly WaitTimeRecalculatorInterface $waitTimeRecalculator,
        private readonly OrderPricingInterface $orderPricing,
        private readonly OrderRewardsInterface $orderRewards,
        private readonly TransactionInterface $transaction,
    ) {}

    public function handle(ExpireAbandonedOrdersCommand $command): int
    {
        $createdBefore = (new \DateTimeImmutable())->modify(sprintf('-%d minutes', $command->ttlMinutes));
        $abandoned = $this->orders->findAbandonedCreated($createdBefore);

        foreach ($abandoned as $order) {
            $this->expire($order);
        }

        return count($abandoned);
    }

    private function expire(Order $order): void
    {
        $order->cancel(OrderStatusSourceEnum::System);

        // Отмена, откат применённых акций и возврат зарезервированных баллов — атомарно
        // (как в CancelOrder): иначе слот промо/резерв баллов останутся навсегда занятыми.
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

        // Побочные эффекты — после коммита.
        $this->realtimeNotifier->publishStatus($order);
        $this->waitTimeRecalculator->recalculateForVenue($order->venueId);
    }
}
