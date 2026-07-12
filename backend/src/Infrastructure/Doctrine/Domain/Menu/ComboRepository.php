<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Menu;

use App\Application\Menu\Entity\Combo\Combo as ComboEntity;
use App\Application\Menu\Entity\Combo\ComboDiscountTypeEnum;
use App\Application\Menu\Entity\Combo\ComboItem;
use App\Application\Menu\Entity\Combo\ComboRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Combo>
 */
class ComboRepository extends ServiceEntityRepository implements ComboRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Combo::class);
    }

    public function save(ComboEntity $combo): int
    {
        $record = $combo->id !== null
            ? $this->find($combo->id)
            : new Combo();

        if ($record === null) {
            throw new \DomainException('Комбо не найдено');
        }

        $record->setVenueId($combo->venueId);
        $record->setExternalId($combo->externalId);
        $record->setName($combo->name);
        $record->setDescription($combo->description);
        $record->setDiscountType($combo->discountType->value);
        $record->setDiscountValue($combo->discountValue);
        $record->setItems(array_map(
            static fn(ComboItem $item): array => $item->toArray(),
            $combo->items,
        ));
        $record->setPosition($combo->position);
        $record->setIsAvailable($combo->isAvailable);
        $record->setIsArchived($combo->isArchived);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $combo->assignId($record->getId());

        return $record->getId();
    }

    public function findById(int $id): ?ComboEntity
    {
        $record = $this->find($id);

        return $record === null ? null : $this->toEntity($record);
    }

    public function findByVenueAndExternalId(int $venueId, string $externalId): ?ComboEntity
    {
        $record = $this->findOneBy(['venueId' => $venueId, 'externalId' => $externalId]);

        return $record === null ? null : $this->toEntity($record);
    }

    /**
     * @return ComboEntity[]
     */
    public function findAllByVenue(int $venueId): array
    {
        return $this->toEntities($this->findBy(['venueId' => $venueId], ['position' => 'ASC']));
    }

    /**
     * @return ComboEntity[]
     */
    public function findActiveByVenue(int $venueId): array
    {
        return $this->toEntities(
            $this->findBy(['venueId' => $venueId, 'isArchived' => false], ['position' => 'ASC']),
        );
    }

    /**
     * @param Combo[] $records
     * @return ComboEntity[]
     */
    private function toEntities(array $records): array
    {
        return array_map(fn(Combo $record): ComboEntity => $this->toEntity($record), $records);
    }

    private function toEntity(Combo $record): ComboEntity
    {
        return new ComboEntity(
            id: $record->getId(),
            venueId: $record->getVenueId(),
            externalId: $record->getExternalId(),
            name: $record->getName(),
            description: $record->getDescription(),
            discountType: ComboDiscountTypeEnum::from($record->getDiscountType()),
            discountValue: $record->getDiscountValue(),
            items: array_map(
                static fn(array $item): ComboItem => ComboItem::fromArray($item),
                $record->getItems(),
            ),
            position: $record->getPosition(),
            isAvailable: $record->isAvailable(),
            isArchived: $record->isArchived(),
        );
    }
}
