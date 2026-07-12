<?php

declare(strict_types=1);

namespace App\Application\Order\Query\GetOrdersByCustomerId;

class GetOrdersByCustomerIdQuery
{
    public function __construct(
        public readonly int $customerId,
    ) {}
}
