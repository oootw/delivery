<?php

declare(strict_types=1);

namespace App\Application\Order\Command\RecordOrderPayment;

use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Realtime\OrderRealtimeNotifierInterface;
use App\Application\Order\Rewards\OrderRewardsInterface;
use App\Application\Order\WaitTime\WaitTimeRecalculatorInterface;
use App\Shared\Transaction\TransactionInterface;

/**
 * Подтверждение онлайн-оплаты заказа по webhook'у. Заказ ищется по orderId (ЮKassa —
 * из metadata платежа) либо по invoiceId (CloudPayments). Переводит заказ в «paid»
 * (после чего он виден точке) и оповещает гостя в реальном времени.
 */
class RecordOrderPaymentHandler
{
    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly OrderRealtimeNotifierInterface $realtimeNotifier,
        private readonly WaitTimeRecalculatorInterface $waitTimeRecalculator,
        private readonly OrderRewardsInterface $orderRewards,
        private readonly TransactionInterface $transaction,
    ) {}

    public function handle(RecordOrderPaymentCommand $command): void
    {
        $order = match (true) {
            $command->orderId !== null => $this->orders->findById($command->orderId),
            $command->invoiceId !== null => $this->orders->findByInvoiceId($command->invoiceId),
            default => throw new \DomainException('В платеже нет номера заказа'),
        };

        if ($order === null) {
            throw new \DomainException('Заказ для платежа не найден');
        }

        // Повторная доставка того же webhook'а (CloudPayments ретраит, пока не получит
        // code:0). Заказ уже оплачен/продвинулся — идемпотентно выходим, чтобы Action
        // ответил code:0 и ретраи прекратились, а не пытались провести оплату дважды.
        if (!$order->isAwaitingPayment()) {
            return;
        }

        $order->registerPayment(
            externalPaymentId: $command->externalPaymentId,
            paidAt: $command->paidAt,
        );

        // Перевод в «paid» и списание зарезервированных баллов — атомарно: иначе при
        // сбое между ними заказ оплачен, а резерв баллов остаётся навсегда зависшим.
        $this->transaction->wrap(function () use ($order): void {
            $this->orders->save($order);
            $this->orderRewards->finalizeOnPaid($order->id);
        });

        // Побочные эффекты — после коммита (их сбой не должен откатывать платёж).
        $this->realtimeNotifier->publishStatus($order);

        // Новый заказ встал в очередь точки — пересчитываем ETA для всех активных.
        $this->waitTimeRecalculator->recalculateForVenue($order->venueId);
    }
}
