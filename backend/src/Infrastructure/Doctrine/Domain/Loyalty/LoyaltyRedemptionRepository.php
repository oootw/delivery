<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use App\Application\Loyalty\Entity\Redemption\LoyaltyRedemption as LoyaltyRedemptionEntity;
use App\Application\Loyalty\Entity\Redemption\LoyaltyRedemptionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoyaltyRedemption>
 */
class LoyaltyRedemptionRepository extends ServiceEntityRepository implements LoyaltyRedemptionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoyaltyRedemption::class);
    }

    public function save(LoyaltyRedemptionEntity $redemption): int
    {
        $record = $redemption->id !== null
            ? $this->find($redemption->id)
            : new LoyaltyRedemption();

        if ($record === null) {
            throw new \DomainException('Списание баллов не найдено');
        }

        $record->setWorkspaceId($redemption->workspaceId);
        $record->setAccountId($redemption->accountId);
        $record->setOrderId($redemption->orderId);
        $record->setCustomerId($redemption->customerId);
        $record->setPoints($redemption->points);
        $record->setStatus($redemption->status);
        $record->setCreatedAt($redemption->createdAt);
        $record->setUpdatedAt($redemption->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $redemption->assignId($record->getId());

        return $record->getId();
    }

    public function findByOrder(int $orderId): ?LoyaltyRedemptionEntity
    {
        $record = $this->findOneBy(['orderId' => $orderId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    private function toEntity(LoyaltyRedemption $record): LoyaltyRedemptionEntity
    {
        return new LoyaltyRedemptionEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            accountId: $record->getAccountId(),
            orderId: $record->getOrderId(),
            customerId: $record->getCustomerId(),
            points: $record->getPoints(),
            status: $record->getStatus(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
