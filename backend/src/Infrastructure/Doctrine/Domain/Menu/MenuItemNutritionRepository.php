<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Menu;

use App\Application\Menu\Entity\MenuItemNutrition\MenuItemNutrition as MenuItemNutritionEntity;
use App\Application\Menu\Entity\MenuItemNutrition\MenuItemNutritionRepositoryInterface;
use App\Application\Menu\Nutrition\Nutrition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MenuItemNutrition>
 */
class MenuItemNutritionRepository extends ServiceEntityRepository implements MenuItemNutritionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuItemNutrition::class);
    }

    public function save(MenuItemNutritionEntity $nutrition): int
    {
        $record = $nutrition->id !== null
            ? $this->find($nutrition->id)
            : new MenuItemNutrition();

        if ($record === null) {
            throw new \DomainException('Оверрайд БЖУ не найден');
        }

        $record->setVenueId($nutrition->venueId);
        $record->setItemExternalId($nutrition->itemExternalId);
        $record->setNutrition($nutrition->nutrition->toArray());

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $nutrition->assignId($record->getId());

        return $record->getId();
    }

    public function findByVenueAndItem(int $venueId, string $itemExternalId): ?MenuItemNutritionEntity
    {
        $record = $this->findOneBy(['venueId' => $venueId, 'itemExternalId' => $itemExternalId]);

        return $record === null ? null : $this->toEntity($record);
    }

    /**
     * @return array<string, MenuItemNutritionEntity>
     */
    public function mapByItemExternalId(int $venueId): array
    {
        $map = [];

        foreach ($this->findBy(['venueId' => $venueId]) as $record) {
            $map[$record->getItemExternalId()] = $this->toEntity($record);
        }

        return $map;
    }

    private function toEntity(MenuItemNutrition $record): MenuItemNutritionEntity
    {
        return new MenuItemNutritionEntity(
            id: $record->getId(),
            venueId: $record->getVenueId(),
            itemExternalId: $record->getItemExternalId(),
            nutrition: Nutrition::fromArray($record->getNutrition()),
        );
    }
}
