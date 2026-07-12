<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\RecordSubscriptionPayment;

/**
 * Успешный платёж от CloudPayments.
 *
 * Первый платёж приходит с invoiceId (наш счёт) и externalId (id подписки в CloudPayments).
 * Рекуррентные списания приходят только с externalId.
 */
class RecordSubscriptionPaymentCommand
{
    public function __construct(
        public readonly ?string $invoiceId,
        public readonly ?string $externalId,
        public readonly \DateTimeImmutable $paidAt,
        /** TransactionId платежа в CloudPayments — для дедупликации повторной доставки webhook'а. */
        public readonly ?string $transactionId = null,
    ) {}
}
