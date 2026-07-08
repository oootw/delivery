<?php

declare(strict_types=1);

namespace App\Application\Order\Query\GetMyOrders;

class Query
{
    public function __construct(
        public readonly int $customerId,
    ) {}
}
