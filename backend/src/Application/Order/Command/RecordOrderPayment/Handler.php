<?php

declare(strict_types=1);

namespace App\Application\Order\Command\RecordOrderPayment;

use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Realtime\OrderRealtimeNotifierInterface;
use App\Application\Order\Rewards\OrderRewardsInterface;
use App\Application\Order\WaitTime\WaitTimeRecalculatorInterface;

/**
 * Подтверждение онлайн-оплаты заказа по webhook'у CloudPayments. Переводит заказ
 * в «paid» (после чего он виден точке) и оповещает гостя в реальном времени.
 */
class Handler
{
    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly OrderRealtimeNotifierInterface $realtimeNotifier,
        private readonly WaitTimeRecalculatorInterface $waitTimeRecalculator,
        private readonly OrderRewardsInterface $orderRewards,
    ) {}

    public function handle(Command $command): void
    {
        if ($command->invoiceId === null) {
            throw new \DomainException('В платеже нет номера заказа');
        }

        $order = $this->orders->findByInvoiceId($command->invoiceId);

        if ($order === null) {
            throw new \DomainException('Заказ для платежа не найден');
        }

        $order->registerPayment(
            externalPaymentId: $command->externalPaymentId,
            paidAt: $command->paidAt,
        );

        $this->orders->save($order);

        // Оплата прошла — списываем зарезервированные баллы.
        $this->orderRewards->finalizeOnPaid($order->id);

        $this->realtimeNotifier->publishStatus($order);

        // Новый заказ встал в очередь точки — пересчитываем ETA для всех активных.
        $this->waitTimeRecalculator->recalculateForVenue($order->venueId);
    }
}
