<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Menu;

use App\Application\Menu\Entity\Category\Category as CategoryEntity;
use App\Application\Menu\Entity\Category\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(CategoryEntity $category): int
    {
        $record = $category->id !== null
            ? $this->find($category->id)
            : new Category();

        if ($record === null) {
            throw new \DomainException('Категория не найдена');
        }

        $record->setVenueId($category->venueId);
        $record->setExternalId($category->externalId);
        $record->setName($category->name);
        $record->setPosition($category->position);
        $record->setIsArchived($category->isArchived);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $category->assignId($record->getId());

        return $record->getId();
    }

    public function findById(int $id): ?CategoryEntity
    {
        $record = $this->find($id);

        return $record === null ? null : $this->toEntity($record);
    }

    /**
     * @return CategoryEntity[]
     */
    public function findAllByVenue(int $venueId): array
    {
        return $this->toEntities($this->findBy(['venueId' => $venueId], ['position' => 'ASC']));
    }

    /**
     * @return CategoryEntity[]
     */
    public function findActiveByVenue(int $venueId): array
    {
        return $this->toEntities(
            $this->findBy(['venueId' => $venueId, 'isArchived' => false], ['position' => 'ASC']),
        );
    }

    /**
     * @param Category[] $records
     * @return CategoryEntity[]
     */
    private function toEntities(array $records): array
    {
        return array_map(fn(Category $record): CategoryEntity => $this->toEntity($record), $records);
    }

    private function toEntity(Category $record): CategoryEntity
    {
        return new CategoryEntity(
            id: $record->getId(),
            venueId: $record->getVenueId(),
            externalId: $record->getExternalId(),
            name: $record->getName(),
            position: $record->getPosition(),
            isArchived: $record->isArchived(),
        );
    }
}
