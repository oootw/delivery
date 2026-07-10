<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use App\Application\Loyalty\Entity\Tier\LoyaltyTier as LoyaltyTierEntity;
use App\Application\Loyalty\Entity\Tier\LoyaltyTierRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoyaltyTier>
 */
class LoyaltyTierRepository extends ServiceEntityRepository implements LoyaltyTierRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoyaltyTier::class);
    }

    public function findByWorkspace(int $workspaceId): array
    {
        $records = $this->findBy(
            ['workspaceId' => $workspaceId],
            ['thresholdKopecks' => 'ASC', 'sortOrder' => 'ASC'],
        );

        return array_map(
            static fn(LoyaltyTier $record): LoyaltyTierEntity => new LoyaltyTierEntity(
                id: $record->getId(),
                workspaceId: $record->getWorkspaceId(),
                name: $record->getName(),
                thresholdKopecks: $record->getThresholdKopecks(),
                earnRateBonusBasisPoints: $record->getEarnRateBonusBasisPoints(),
                permanentDiscountBasisPoints: $record->getPermanentDiscountBasisPoints(),
                sortOrder: $record->getSortOrder(),
            ),
            $records,
        );
    }

    public function replaceAll(int $workspaceId, array $tiers): void
    {
        $manager = $this->getEntityManager();

        foreach ($this->findBy(['workspaceId' => $workspaceId]) as $existing) {
            $manager->remove($existing);
        }

        $manager->flush();

        foreach ($tiers as $tier) {
            $record = new LoyaltyTier();
            $record->setWorkspaceId($tier->workspaceId);
            $record->setName($tier->name);
            $record->setThresholdKopecks($tier->thresholdKopecks);
            $record->setEarnRateBonusBasisPoints($tier->earnRateBonusBasisPoints);
            $record->setPermanentDiscountBasisPoints($tier->permanentDiscountBasisPoints);
            $record->setSortOrder($tier->sortOrder);

            $manager->persist($record);
        }

        $manager->flush();
    }
}
