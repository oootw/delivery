<?php

declare(strict_types=1);

namespace App\Application\Order\Query\GetOrder;

use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Query\OrderView;
use App\Application\Workspace\Entity\Membership\MembershipRepositoryInterface;

/**
 * Один заказ. Доступен своему гостю, а также персоналу точки (участнику воркспейса).
 */
class Fetcher
{
    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly MembershipRepositoryInterface $memberships,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function fetch(Query $query): array
    {
        $order = $this->orders->findById($query->orderId);

        if ($order === null) {
            throw new \DomainException('Заказ не найден');
        }

        $isOwnOrder = $order->customerId === $query->userId;
        $isVenueStaff = $this->memberships->findByWorkspaceAndUser($order->workspaceId, $query->userId) !== null;

        if (!$isOwnOrder && !$isVenueStaff) {
            throw new \DomainException('Нет доступа к заказу');
        }

        return OrderView::fromOrder($order);
    }
}
