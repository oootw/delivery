<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use App\Application\Loyalty\Entity\Account\LoyaltyAccount as LoyaltyAccountEntity;
use App\Application\Loyalty\Entity\Account\LoyaltyAccountRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoyaltyAccount>
 */
class LoyaltyAccountRepository extends ServiceEntityRepository implements LoyaltyAccountRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoyaltyAccount::class);
    }

    public function save(LoyaltyAccountEntity $account): int
    {
        $record = $account->id !== null
            ? $this->find($account->id)
            : new LoyaltyAccount();

        if ($record === null) {
            throw new \DomainException('Бонусный кошелёк не найден');
        }

        $record->setWorkspaceId($account->workspaceId);
        $record->setCustomerId($account->customerId);
        $record->setPointsBalance($account->pointsBalance);
        $record->setReservedPoints($account->reservedPoints);
        $record->setLifetimeSpentKopecks($account->lifetimeSpentKopecks);
        $record->setCurrentTierId($account->currentTierId);
        $record->setCreatedAt($account->createdAt);
        $record->setUpdatedAt($account->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $account->assignId($record->getId());

        return $record->getId();
    }

    public function findByCustomer(int $workspaceId, int $customerId): ?LoyaltyAccountEntity
    {
        $record = $this->findOneBy(['workspaceId' => $workspaceId, 'customerId' => $customerId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function getOrCreate(int $workspaceId, int $customerId): LoyaltyAccountEntity
    {
        $existing = $this->findByCustomer($workspaceId, $customerId);

        if ($existing !== null) {
            return $existing;
        }

        $account = LoyaltyAccountEntity::buildNew($workspaceId, $customerId);
        $this->save($account);

        return $account;
    }

    public function getOrCreateForUpdate(int $workspaceId, int $customerId): LoyaltyAccountEntity
    {
        $record = $this->createQueryBuilder('a')
            ->where('a.workspaceId = :workspaceId')
            ->andWhere('a.customerId = :customerId')
            ->setParameter('workspaceId', $workspaceId)
            ->setParameter('customerId', $customerId)
            ->getQuery()
            ->setLockMode(LockMode::PESSIMISTIC_WRITE)
            ->getOneOrNullResult();

        if ($record !== null) {
            return $this->toEntity($record);
        }

        // Кошелька ещё нет (первое списание гостя) — создаём. Конкурентное создание
        // отсечёт уникальный индекс (workspace_id, customer_id).
        $account = LoyaltyAccountEntity::buildNew($workspaceId, $customerId);
        $this->save($account);

        return $account;
    }

    public function findByWorkspaceWithPoints(int $workspaceId): array
    {
        return array_map(
            fn(LoyaltyAccount $record): LoyaltyAccountEntity => $this->toEntity($record),
            $this->createQueryBuilder('a')
                ->where('a.workspaceId = :workspaceId')
                ->andWhere('a.pointsBalance > 0')
                ->setParameter('workspaceId', $workspaceId)
                ->getQuery()
                ->getResult(),
        );
    }

    private function toEntity(LoyaltyAccount $record): LoyaltyAccountEntity
    {
        return new LoyaltyAccountEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            customerId: $record->getCustomerId(),
            pointsBalance: $record->getPointsBalance(),
            reservedPoints: $record->getReservedPoints(),
            lifetimeSpentKopecks: $record->getLifetimeSpentKopecks(),
            currentTierId: $record->getCurrentTierId(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
