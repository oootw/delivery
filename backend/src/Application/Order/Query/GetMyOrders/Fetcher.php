<?php

declare(strict_types=1);

namespace App\Application\Order\Query\GetMyOrders;

use App\Application\Order\Entity\Order\Order;
use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Query\OrderView;

/**
 * История заказов гостя.
 */
class Fetcher
{
    public function __construct(
        private readonly OrderRepositoryInterface $orders,
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetch(Query $query): array
    {
        return array_map(
            static fn(Order $order): array => OrderView::fromOrder($order),
            $this->orders->findAllByCustomer($query->customerId),
        );
    }
}
