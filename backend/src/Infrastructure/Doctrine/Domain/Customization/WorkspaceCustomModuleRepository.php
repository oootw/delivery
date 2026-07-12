<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Customization;

use App\Application\Customization\Entity\WorkspaceCustomModule\WorkspaceCustomModule as WorkspaceCustomModuleEntity;
use App\Application\Customization\Entity\WorkspaceCustomModule\WorkspaceCustomModuleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkspaceCustomModule>
 */
class WorkspaceCustomModuleRepository extends ServiceEntityRepository implements WorkspaceCustomModuleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkspaceCustomModule::class);
    }

    public function save(WorkspaceCustomModuleEntity $module): int
    {
        $record = $module->id !== null
            ? $this->find($module->id)
            : new WorkspaceCustomModule();

        if ($record === null) {
            throw new \DomainException('Активация модуля не найдена');
        }

        $record->setWorkspaceId($module->workspaceId);
        $record->setSlug($module->slug);
        $record->setIsEnabled($module->isEnabled);
        $record->setCreatedAt($module->createdAt);
        $record->setUpdatedAt($module->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $module->assignId($record->getId());

        return $record->getId();
    }

    public function findByWorkspaceAndSlug(int $workspaceId, string $slug): ?WorkspaceCustomModuleEntity
    {
        $record = $this->findOneBy(['workspaceId' => $workspaceId, 'slug' => $slug]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findByWorkspace(int $workspaceId): array
    {
        return array_map(
            fn(WorkspaceCustomModule $record): WorkspaceCustomModuleEntity => $this->toEntity($record),
            $this->findBy(['workspaceId' => $workspaceId]),
        );
    }

    public function findEnabledSlugsByWorkspace(int $workspaceId): array
    {
        $records = $this->findBy(['workspaceId' => $workspaceId, 'isEnabled' => true]);

        return array_values(array_map(
            static fn(WorkspaceCustomModule $record): string => $record->getSlug(),
            $records,
        ));
    }

    private function toEntity(WorkspaceCustomModule $record): WorkspaceCustomModuleEntity
    {
        return new WorkspaceCustomModuleEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            slug: $record->getSlug(),
            isEnabled: $record->isEnabled(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
