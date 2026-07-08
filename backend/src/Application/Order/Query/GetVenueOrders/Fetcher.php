<?php

declare(strict_types=1);

namespace App\Application\Order\Query\GetVenueOrders;

use App\Application\Order\Entity\Order\Order;
use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Entity\Order\OrderStatusEnum;
use App\Application\Order\Query\OrderView;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Заказы точки для персонала. Доступно любому участнику воркспейса.
 * Необязательный фильтр по статусу — для рабочих экранов кухни/выдачи.
 */
class Fetcher
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly OrderRepositoryInterface $orders,
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetch(Query $query): array
    {
        $venue = $this->venues->findById($query->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $this->workspaceAccess->requireMember(
            workspaceId: $venue->workspaceId,
            userId: $query->userId,
        );

        $status = $query->status !== null ? OrderStatusEnum::tryFrom($query->status) : null;

        if ($query->status !== null && $status === null) {
            throw new \DomainException('Неизвестный статус для фильтра');
        }

        return array_map(
            static fn(Order $order): array => OrderView::fromOrder($order),
            $this->orders->findAllByVenue($query->venueId, $status),
        );
    }
}
