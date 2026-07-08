<?php

declare(strict_types=1);

namespace App\Application\Order\Query\GetOrder;

class Query
{
    public function __construct(
        public readonly int $orderId,
        public readonly int $userId,
    ) {}
}
