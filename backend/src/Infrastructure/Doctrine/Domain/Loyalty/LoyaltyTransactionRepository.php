<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use App\Application\Loyalty\Entity\Transaction\LoyaltyTransaction as LoyaltyTransactionEntity;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionRepositoryInterface;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoyaltyTransaction>
 */
class LoyaltyTransactionRepository extends ServiceEntityRepository implements LoyaltyTransactionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoyaltyTransaction::class);
    }

    public function save(LoyaltyTransactionEntity $transaction): void
    {
        $record = new LoyaltyTransaction();
        $record->setAccountId($transaction->accountId);
        $record->setWorkspaceId($transaction->workspaceId);
        $record->setOrderId($transaction->orderId);
        $record->setType($transaction->type);
        $record->setPoints($transaction->points);
        $record->setBalanceAfter($transaction->balanceAfter);
        $record->setComment($transaction->comment);
        $record->setCreatedAt($transaction->createdAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $transaction->assignId($record->getId());
    }

    public function findByAccount(int $accountId, int $limit): array
    {
        $records = $this->findBy(['accountId' => $accountId], ['createdAt' => 'DESC', 'id' => 'DESC'], $limit);

        return array_map(
            fn(LoyaltyTransaction $record): LoyaltyTransactionEntity => $this->toEntity($record),
            $records,
        );
    }

    public function findAllByAccountAsc(int $accountId): array
    {
        $records = $this->findBy(['accountId' => $accountId], ['createdAt' => 'ASC', 'id' => 'ASC']);

        return array_map(
            fn(LoyaltyTransaction $record): LoyaltyTransactionEntity => $this->toEntity($record),
            $records,
        );
    }

    private function toEntity(LoyaltyTransaction $record): LoyaltyTransactionEntity
    {
        return new LoyaltyTransactionEntity(
            id: $record->getId(),
            accountId: $record->getAccountId(),
            workspaceId: $record->getWorkspaceId(),
            orderId: $record->getOrderId(),
            type: $record->getType(),
            points: $record->getPoints(),
            balanceAfter: $record->getBalanceAfter(),
            comment: $record->getComment(),
            createdAt: $record->getCreatedAt(),
        );
    }

    public function existsEarnForOrder(int $orderId): bool
    {
        $count = (int) $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.orderId = :orderId')
            ->andWhere('t.type = :type')
            ->setParameter('orderId', $orderId)
            ->setParameter('type', LoyaltyTransactionTypeEnum::Earn->value)
            ->getQuery()
            ->getSingleScalarResult();

        return $count > 0;
    }
}
