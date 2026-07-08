<?php

declare(strict_types=1);

namespace App\Application\Order\Entity\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): int;

    public function findById(int $id): ?Order;

    public function findByInvoiceId(string $invoiceId): ?Order;

    /**
     * @return Order[]
     */
    public function findAllByCustomer(int $customerId): array;

    /**
     * Заказы точки для персонала. Если передан $status — только в этом статусе.
     *
     * @return Order[]
     */
    public function findAllByVenue(int $venueId, ?OrderStatusEnum $status = null): array;

    /**
     * Активные (не финальные и уже оплаченные) заказы точки — для пересчёта ETA:
     * статусы paid/accepted/cooking/ready/on_the_way.
     *
     * @return Order[]
     */
    public function findInProgressByVenue(int $venueId): array;

    /**
     * Недавние заказы точки, дошедшие до готовности (ready/on_the_way/completed) —
     * для исторической калибровки времени готовки.
     *
     * @return Order[]
     */
    public function findRecentReadyByVenue(int $venueId, int $limit): array;

    /**
     * Идентификаторы точек, у которых сейчас есть активные заказы — для таймера пересчёта.
     *
     * @return int[]
     */
    public function findVenueIdsInProgress(): array;
}
