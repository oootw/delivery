<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Customization;

use App\Application\Customization\Entity\WorkspaceSettings\WorkspaceSettings as WorkspaceSettingsEntity;
use App\Application\Customization\Entity\WorkspaceSettings\WorkspaceSettingsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkspaceSettings>
 */
class WorkspaceSettingsRepository extends ServiceEntityRepository implements WorkspaceSettingsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkspaceSettings::class);
    }

    public function save(WorkspaceSettingsEntity $settings): int
    {
        $record = $settings->id !== null
            ? $this->find($settings->id)
            : new WorkspaceSettings();

        if ($record === null) {
            throw new \DomainException('Настройки воркспейса не найдены');
        }

        $record->setWorkspaceId($settings->workspaceId);
        $record->setValues($settings->values);
        $record->setCreatedAt($settings->createdAt);
        $record->setUpdatedAt($settings->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $settings->assignId($record->getId());

        return $record->getId();
    }

    public function findByWorkspace(int $workspaceId): ?WorkspaceSettingsEntity
    {
        $record = $this->findOneBy(['workspaceId' => $workspaceId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function getOrCreate(int $workspaceId): WorkspaceSettingsEntity
    {
        return $this->findByWorkspace($workspaceId)
            ?? WorkspaceSettingsEntity::buildNew($workspaceId);
    }

    private function toEntity(WorkspaceSettings $record): WorkspaceSettingsEntity
    {
        return new WorkspaceSettingsEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            values: $record->getValues(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
