<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Subscription;

use App\Application\Subscription\Entity\Subscription\Subscription as SubscriptionEntity;
use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;
use App\Application\Subscription\Entity\Subscription\SubscriptionStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Subscription>
 */
class SubscriptionRepository extends ServiceEntityRepository implements SubscriptionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    public function save(SubscriptionEntity $subscription): int
    {
        $record = $subscription->id !== null
            ? $this->find($subscription->id)
            : new Subscription();

        if ($record === null) {
            throw new \DomainException('Подписка не найдена');
        }

        $record->setUserId($subscription->userId);
        $record->setTarifCode($subscription->tarifCode);
        $record->setStatus($subscription->status);
        $record->setInvoiceId($subscription->invoiceId);
        $record->setExternalId($subscription->externalId);
        $record->setCurrentPeriodEnd($subscription->currentPeriodEnd);
        $record->setLastPaymentTransactionId($subscription->lastPaymentTransactionId);
        $record->setCreatedAt($subscription->createdAt);
        $record->setUpdatedAt($subscription->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $subscription->assignId($record->getId());

        return $record->getId();
    }

    public function findById(int $id): ?SubscriptionEntity
    {
        $record = $this->find($id);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findByInvoiceId(string $invoiceId): ?SubscriptionEntity
    {
        $record = $this->findOneBy(['invoiceId' => $invoiceId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findByExternalId(string $externalId): ?SubscriptionEntity
    {
        $record = $this->findOneBy(['externalId' => $externalId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findActiveByUser(int $userId): ?SubscriptionEntity
    {
        $record = $this->findOneBy([
            'userId' => $userId,
            'status' => SubscriptionStatusEnum::Active,
        ]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findPendingByUser(int $userId): ?SubscriptionEntity
    {
        $record = $this->findOneBy(
            ['userId' => $userId, 'status' => SubscriptionStatusEnum::Pending],
            ['createdAt' => 'DESC'],
        );

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findLatestByUser(int $userId): ?SubscriptionEntity
    {
        $record = $this->findOneBy(['userId' => $userId], ['createdAt' => 'DESC']);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findPastDueOlderThan(\DateTimeImmutable $updatedBefore): array
    {
        return array_map(
            fn(Subscription $record): SubscriptionEntity => $this->toEntity($record),
            $this->createQueryBuilder('s')
                ->where('s.status = :status')
                ->andWhere('s.updatedAt < :cutoff')
                ->setParameter('status', SubscriptionStatusEnum::PastDue)
                ->setParameter('cutoff', $updatedBefore)
                ->orderBy('s.updatedAt', 'ASC')
                ->getQuery()
                ->getResult(),
        );
    }

    private function toEntity(Subscription $record): SubscriptionEntity
    {
        return new SubscriptionEntity(
            id: $record->getId(),
            userId: $record->getUserId(),
            tarifCode: $record->getTarifCode(),
            status: $record->getStatus(),
            invoiceId: $record->getInvoiceId(),
            externalId: $record->getExternalId(),
            currentPeriodEnd: $record->getCurrentPeriodEnd(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
            lastPaymentTransactionId: $record->getLastPaymentTransactionId(),
        );
    }
}
