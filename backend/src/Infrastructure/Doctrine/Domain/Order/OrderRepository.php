<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Order;

use App\Application\Order\Entity\Order\Order as OrderEntity;
use App\Application\Order\Entity\Order\OrderItem;
use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Entity\Order\OrderStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    /** Оплаченные и ещё не завершённые заказы — участвуют в пересчёте времени ожидания. */
    private const IN_PROGRESS_STATUSES = [
        OrderStatusEnum::Paid,
        OrderStatusEnum::Accepted,
        OrderStatusEnum::Cooking,
        OrderStatusEnum::Ready,
        OrderStatusEnum::OnTheWay,
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(OrderEntity $order): int
    {
        $record = $order->id !== null
            ? $this->find($order->id)
            : new Order();

        if ($record === null) {
            throw new \DomainException('Заказ не найден');
        }

        $record->setWorkspaceId($order->workspaceId);
        $record->setVenueId($order->venueId);
        $record->setCustomerId($order->customerId);
        $record->setType($order->type);
        $record->setStatus($order->status);
        $record->setItems(array_map(
            static fn(OrderItem $item): array => $item->toArray(),
            $order->items,
        ));
        $record->setTotalKopecks($order->totalKopecks);
        $record->setContactName($order->contactName);
        $record->setContactPhone($order->contactPhone);
        $record->setDeliveryAddress($order->deliveryAddress);
        $record->setComment($order->comment);
        $record->setInvoiceId($order->invoiceId);
        $record->setExternalPaymentId($order->externalPaymentId);
        $record->setEstimatedWaitMinutes($order->estimatedWaitMinutes);
        $record->setHistory($order->history);
        $record->setCreatedAt($order->createdAt);
        $record->setUpdatedAt($order->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $order->assignId($record->getId());

        return $record->getId();
    }

    public function findById(int $id): ?OrderEntity
    {
        $record = $this->find($id);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findByInvoiceId(string $invoiceId): ?OrderEntity
    {
        $record = $this->findOneBy(['invoiceId' => $invoiceId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findAllByCustomer(int $customerId): array
    {
        return array_map(
            fn(Order $record): OrderEntity => $this->toEntity($record),
            $this->findBy(['customerId' => $customerId], ['createdAt' => 'DESC']),
        );
    }

    public function findAllByVenue(int $venueId, ?OrderStatusEnum $status = null): array
    {
        $criteria = ['venueId' => $venueId];

        if ($status !== null) {
            $criteria['status'] = $status;
        }

        return array_map(
            fn(Order $record): OrderEntity => $this->toEntity($record),
            $this->findBy($criteria, ['createdAt' => 'DESC']),
        );
    }

    public function findInProgressByVenue(int $venueId): array
    {
        return array_map(
            fn(Order $record): OrderEntity => $this->toEntity($record),
            $this->findBy(
                ['venueId' => $venueId, 'status' => self::IN_PROGRESS_STATUSES],
                ['createdAt' => 'ASC'],
            ),
        );
    }

    public function findRecentReadyByVenue(int $venueId, int $limit): array
    {
        $statuses = [OrderStatusEnum::Ready, OrderStatusEnum::OnTheWay, OrderStatusEnum::Completed];

        return array_map(
            fn(Order $record): OrderEntity => $this->toEntity($record),
            $this->findBy(
                ['venueId' => $venueId, 'status' => $statuses],
                ['createdAt' => 'DESC'],
                $limit,
            ),
        );
    }

    public function findVenueIdsInProgress(): array
    {
        $rows = $this->createQueryBuilder('o')
            ->select('DISTINCT o.venueId AS venueId')
            ->where('o.status IN (:statuses)')
            ->setParameter('statuses', self::IN_PROGRESS_STATUSES)
            ->getQuery()
            ->getScalarResult();

        return array_map(static fn(array $row): int => (int) $row['venueId'], $rows);
    }

    private function toEntity(Order $record): OrderEntity
    {
        return new OrderEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            venueId: $record->getVenueId(),
            customerId: $record->getCustomerId(),
            type: $record->getType(),
            status: $record->getStatus(),
            items: array_map(
                static fn(array $item): OrderItem => OrderItem::fromArray($item),
                $record->getItems(),
            ),
            totalKopecks: $record->getTotalKopecks(),
            contactName: $record->getContactName(),
            contactPhone: $record->getContactPhone(),
            deliveryAddress: $record->getDeliveryAddress(),
            comment: $record->getComment(),
            invoiceId: $record->getInvoiceId(),
            externalPaymentId: $record->getExternalPaymentId(),
            estimatedWaitMinutes: $record->getEstimatedWaitMinutes(),
            history: $record->getHistory(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
