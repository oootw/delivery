<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use App\Application\Loyalty\Entity\Program\LoyaltyProgram as LoyaltyProgramEntity;
use App\Application\Loyalty\Entity\Program\LoyaltyProgramRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoyaltyProgram>
 */
class LoyaltyProgramRepository extends ServiceEntityRepository implements LoyaltyProgramRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoyaltyProgram::class);
    }

    public function save(LoyaltyProgramEntity $program): int
    {
        $record = $program->id !== null
            ? $this->find($program->id)
            : new LoyaltyProgram();

        if ($record === null) {
            throw new \DomainException('Программа лояльности не найдена');
        }

        $record->setWorkspaceId($program->workspaceId);
        $record->setIsEnabled($program->isEnabled);
        $record->setEarnRateBasisPoints($program->earnRateBasisPoints);
        $record->setPointValueKopecks($program->pointValueKopecks);
        $record->setRedeemMaxPercentBasisPoints($program->redeemMaxPercentBasisPoints);
        $record->setPointsLifetimeDays($program->pointsLifetimeDays);
        $record->setCreatedAt($program->createdAt);
        $record->setUpdatedAt($program->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $program->assignId($record->getId());

        return $record->getId();
    }

    public function findByWorkspace(int $workspaceId): ?LoyaltyProgramEntity
    {
        $record = $this->findOneBy(['workspaceId' => $workspaceId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findAllWithExpiry(): array
    {
        return array_map(
            fn(LoyaltyProgram $record): LoyaltyProgramEntity => $this->toEntity($record),
            $this->createQueryBuilder('p')
                ->where('p.isEnabled = true')
                ->andWhere('p.pointsLifetimeDays IS NOT NULL')
                ->getQuery()
                ->getResult(),
        );
    }

    private function toEntity(LoyaltyProgram $record): LoyaltyProgramEntity
    {
        return new LoyaltyProgramEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            isEnabled: $record->isEnabled(),
            earnRateBasisPoints: $record->getEarnRateBasisPoints(),
            pointValueKopecks: $record->getPointValueKopecks(),
            redeemMaxPercentBasisPoints: $record->getRedeemMaxPercentBasisPoints(),
            pointsLifetimeDays: $record->getPointsLifetimeDays(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
