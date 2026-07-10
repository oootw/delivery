<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Loyalty;

use App\Application\Loyalty\Entity\Stamp\StampProgress as StampProgressEntity;
use App\Application\Loyalty\Entity\Stamp\StampProgressRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StampProgress>
 */
class StampProgressRepository extends ServiceEntityRepository implements StampProgressRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StampProgress::class);
    }

    public function save(StampProgressEntity $progress): int
    {
        $record = $progress->id !== null
            ? $this->find($progress->id)
            : new StampProgress();

        if ($record === null) {
            throw new \DomainException('Прогресс штампов не найден');
        }

        $record->setWorkspaceId($progress->workspaceId);
        $record->setCustomerId($progress->customerId);
        $record->setCurrentStamps($progress->currentStamps);
        $record->setCreatedAt($progress->createdAt);
        $record->setUpdatedAt($progress->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $progress->assignId($record->getId());

        return $record->getId();
    }

    public function findByCustomer(int $workspaceId, int $customerId): ?StampProgressEntity
    {
        $record = $this->findOneBy(['workspaceId' => $workspaceId, 'customerId' => $customerId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function getOrCreate(int $workspaceId, int $customerId): StampProgressEntity
    {
        $existing = $this->findByCustomer($workspaceId, $customerId);

        if ($existing !== null) {
            return $existing;
        }

        $progress = StampProgressEntity::buildNew($workspaceId, $customerId);
        $this->save($progress);

        return $progress;
    }

    private function toEntity(StampProgress $record): StampProgressEntity
    {
        return new StampProgressEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            customerId: $record->getCustomerId(),
            currentStamps: $record->getCurrentStamps(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
