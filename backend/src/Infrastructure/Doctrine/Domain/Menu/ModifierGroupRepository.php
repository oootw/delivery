<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Menu;

use App\Application\Menu\Entity\ModifierGroup\ModifierGroup as ModifierGroupEntity;
use App\Application\Menu\Entity\ModifierGroup\ModifierGroupRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ModifierGroup>
 */
class ModifierGroupRepository extends ServiceEntityRepository implements ModifierGroupRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModifierGroup::class);
    }

    public function save(ModifierGroupEntity $group): int
    {
        $record = $group->id !== null
            ? $this->find($group->id)
            : new ModifierGroup();

        if ($record === null) {
            throw new \DomainException('Группа модификаторов не найдена');
        }

        $record->setVenueId($group->venueId);
        $record->setExternalId($group->externalId);
        $record->setName($group->name);
        $record->setMinSelection($group->minSelection);
        $record->setMaxSelection($group->maxSelection);
        $record->setIsArchived($group->isArchived);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $group->assignId($record->getId());

        return $record->getId();
    }

    public function findById(int $id): ?ModifierGroupEntity
    {
        $record = $this->find($id);

        return $record === null ? null : $this->toEntity($record);
    }

    /**
     * @return ModifierGroupEntity[]
     */
    public function findAllByVenue(int $venueId): array
    {
        return $this->toEntities($this->findBy(['venueId' => $venueId]));
    }

    /**
     * @return ModifierGroupEntity[]
     */
    public function findActiveByVenue(int $venueId): array
    {
        return $this->toEntities($this->findBy(['venueId' => $venueId, 'isArchived' => false]));
    }

    /**
     * @param ModifierGroup[] $records
     * @return ModifierGroupEntity[]
     */
    private function toEntities(array $records): array
    {
        return array_map(fn(ModifierGroup $record): ModifierGroupEntity => $this->toEntity($record), $records);
    }

    private function toEntity(ModifierGroup $record): ModifierGroupEntity
    {
        return new ModifierGroupEntity(
            id: $record->getId(),
            venueId: $record->getVenueId(),
            externalId: $record->getExternalId(),
            name: $record->getName(),
            minSelection: $record->getMinSelection(),
            maxSelection: $record->getMaxSelection(),
            isArchived: $record->isArchived(),
        );
    }
}
