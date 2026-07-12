<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Customization;

use App\Application\Customization\Entity\WorkspaceFeatureGrant\WorkspaceFeatureGrant as WorkspaceFeatureGrantEntity;
use App\Application\Customization\Entity\WorkspaceFeatureGrant\WorkspaceFeatureGrantRepositoryInterface;
use App\Shared\Enum\Feature\FeatureCodeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkspaceFeatureGrant>
 */
class WorkspaceFeatureGrantRepository extends ServiceEntityRepository implements WorkspaceFeatureGrantRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkspaceFeatureGrant::class);
    }

    public function save(WorkspaceFeatureGrantEntity $grant): int
    {
        $record = $grant->id !== null
            ? $this->find($grant->id)
            : new WorkspaceFeatureGrant();

        if ($record === null) {
            throw new \DomainException('Грант возможности не найден');
        }

        $record->setWorkspaceId($grant->workspaceId);
        $record->setFeature($grant->feature);
        $record->setCreatedAt($grant->createdAt);
        $record->setUpdatedAt($grant->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $grant->assignId($record->getId());

        return $record->getId();
    }

    public function findByWorkspaceAndFeature(int $workspaceId, FeatureCodeEnum $feature): ?WorkspaceFeatureGrantEntity
    {
        $record = $this->findOneBy(['workspaceId' => $workspaceId, 'feature' => $feature]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function grantedFeatures(int $workspaceId): array
    {
        $records = $this->findBy(['workspaceId' => $workspaceId]);

        return array_values(array_map(
            static fn(WorkspaceFeatureGrant $record): FeatureCodeEnum => $record->getFeature(),
            $records,
        ));
    }

    private function toEntity(WorkspaceFeatureGrant $record): WorkspaceFeatureGrantEntity
    {
        return new WorkspaceFeatureGrantEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            feature: $record->getFeature(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
