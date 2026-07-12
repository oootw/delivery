<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Menu;

use App\Application\Menu\Entity\Modifier\Modifier as ModifierEntity;
use App\Application\Menu\Entity\Modifier\ModifierRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Modifier>
 */
class ModifierRepository extends ServiceEntityRepository implements ModifierRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Modifier::class);
    }

    public function save(ModifierEntity $modifier): int
    {
        $record = $modifier->id !== null
            ? $this->find($modifier->id)
            : new Modifier();

        if ($record === null) {
            throw new \DomainException('Модификатор не найден');
        }

        $record->setVenueId($modifier->venueId);
        $record->setExternalId($modifier->externalId);
        $record->setModifierGroupExternalId($modifier->modifierGroupExternalId);
        $record->setName($modifier->name);
        $record->setPriceKopecks($modifier->priceKopecks);
        $record->setIsArchived($modifier->isArchived);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $modifier->assignId($record->getId());

        return $record->getId();
    }

    public function findById(int $id): ?ModifierEntity
    {
        $record = $this->find($id);

        return $record === null ? null : $this->toEntity($record);
    }

    /**
     * @return ModifierEntity[]
     */
    public function findAllByVenue(int $venueId): array
    {
        return $this->toEntities($this->findBy(['venueId' => $venueId]));
    }

    /**
     * @return ModifierEntity[]
     */
    public function findActiveByVenue(int $venueId): array
    {
        return $this->toEntities($this->findBy(['venueId' => $venueId, 'isArchived' => false]));
    }

    /**
     * @param Modifier[] $records
     * @return ModifierEntity[]
     */
    private function toEntities(array $records): array
    {
        return array_map(fn(Modifier $record): ModifierEntity => $this->toEntity($record), $records);
    }

    private function toEntity(Modifier $record): ModifierEntity
    {
        return new ModifierEntity(
            id: $record->getId(),
            venueId: $record->getVenueId(),
            externalId: $record->getExternalId(),
            modifierGroupExternalId: $record->getModifierGroupExternalId(),
            name: $record->getName(),
            priceKopecks: $record->getPriceKopecks(),
            isArchived: $record->isArchived(),
        );
    }
}
