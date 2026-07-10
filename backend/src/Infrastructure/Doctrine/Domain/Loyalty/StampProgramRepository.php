<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use App\Application\Loyalty\Entity\Stamp\StampProgram as StampProgramEntity;
use App\Application\Loyalty\Entity\Stamp\StampProgramRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StampProgram>
 */
class StampProgramRepository extends ServiceEntityRepository implements StampProgramRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StampProgram::class);
    }

    public function save(StampProgramEntity $program): int
    {
        $record = $program->id !== null
            ? $this->find($program->id)
            : new StampProgram();

        if ($record === null) {
            throw new \DomainException('Программа штампов не найдена');
        }

        $record->setWorkspaceId($program->workspaceId);
        $record->setIsEnabled($program->isEnabled);
        $record->setRequiredCount($program->requiredCount);
        $record->setRewardPoints($program->rewardPoints);
        $record->setCreatedAt($program->createdAt);
        $record->setUpdatedAt($program->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $program->assignId($record->getId());

        return $record->getId();
    }

    public function findByWorkspace(int $workspaceId): ?StampProgramEntity
    {
        $record = $this->findOneBy(['workspaceId' => $workspaceId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    private function toEntity(StampProgram $record): StampProgramEntity
    {
        return new StampProgramEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            isEnabled: $record->isEnabled(),
            requiredCount: $record->getRequiredCount(),
            rewardPoints: $record->getRewardPoints(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
