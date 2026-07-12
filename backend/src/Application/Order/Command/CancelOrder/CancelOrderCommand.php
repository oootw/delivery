<?php

declare(strict_types=1);

namespace App\Application\Order\Command\CancelOrder;

class CancelOrderCommand
{
    public function __construct(
        public readonly int $orderId,
        public readonly int $customerId,
    ) {}
}
