<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Menu;

use App\Application\Menu\Entity\MenuItem\MenuItem as MenuItemEntity;
use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MenuItem>
 */
class MenuItemRepository extends ServiceEntityRepository implements MenuItemRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuItem::class);
    }

    public function save(MenuItemEntity $item): int
    {
        $record = $item->id !== null
            ? $this->find($item->id)
            : new MenuItem();

        if ($record === null) {
            throw new \DomainException('Позиция меню не найдена');
        }

        $record->setVenueId($item->venueId);
        $record->setExternalId($item->externalId);
        $record->setCategoryExternalId($item->categoryExternalId);
        $record->setName($item->name);
        $record->setDescription($item->description);
        $record->setPriceKopecks($item->priceKopecks);
        $record->setImageUrl($item->imageUrl);
        $record->setIsAvailable($item->isAvailable);
        $record->setPosition($item->position);
        $record->setModifierGroupExternalIds($item->modifierGroupExternalIds);
        $record->setIsArchived($item->isArchived);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $item->assignId($record->getId());

        return $record->getId();
    }

    /**
     * @return MenuItemEntity[]
     */
    public function findAllByVenue(int $venueId): array
    {
        return $this->toEntities($this->findBy(['venueId' => $venueId], ['position' => 'ASC']));
    }

    /**
     * @return MenuItemEntity[]
     */
    public function findActiveByVenue(int $venueId): array
    {
        return $this->toEntities(
            $this->findBy(['venueId' => $venueId, 'isArchived' => false], ['position' => 'ASC']),
        );
    }

    public function findById(int $id): ?MenuItemEntity
    {
        $record = $this->find($id);

        return $record !== null ? $this->toEntity($record) : null;
    }

    /**
     * @param MenuItem[] $records
     * @return MenuItemEntity[]
     */
    private function toEntities(array $records): array
    {
        return array_map(fn(MenuItem $record): MenuItemEntity => $this->toEntity($record), $records);
    }

    private function toEntity(MenuItem $record): MenuItemEntity
    {
        return new MenuItemEntity(
            id: $record->getId(),
            venueId: $record->getVenueId(),
            externalId: $record->getExternalId(),
            categoryExternalId: $record->getCategoryExternalId(),
            name: $record->getName(),
            description: $record->getDescription(),
            priceKopecks: $record->getPriceKopecks(),
            imageUrl: $record->getImageUrl(),
            isAvailable: $record->isAvailable(),
            position: $record->getPosition(),
            modifierGroupExternalIds: $record->getModifierGroupExternalIds(),
            isArchived: $record->isArchived(),
        );
    }
}
