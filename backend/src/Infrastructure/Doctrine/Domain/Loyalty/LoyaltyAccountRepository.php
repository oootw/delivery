<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use App\Application\Loyalty\Entity\Account\LoyaltyAccount as LoyaltyAccountEntity;
use App\Application\Loyalty\Entity\Account\LoyaltyAccountRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    private function toEntity(LoyaltyAccount $record): LoyaltyAccountEntity
    {
        return new LoyaltyAccountEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            customerId: $record->getCustomerId(),
            pointsBalance: $record->getPointsBalance(),
            reservedPoints: $record->getReservedPoints(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
