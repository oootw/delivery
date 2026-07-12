<?php

declare(strict_types=1);

namespace App\Application\Order\Command\RecordOrderPayment;

class RecordOrderPaymentCommand
{
    public function __construct(
        public readonly ?string $invoiceId,
        public readonly ?string $externalPaymentId,
        public readonly \DateTimeImmutable $paidAt,
        public readonly ?int $orderId = null,
    ) {}
}
