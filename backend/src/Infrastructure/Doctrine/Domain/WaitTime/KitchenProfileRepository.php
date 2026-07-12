<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\WaitTime;

use App\Application\WaitTime\Entity\KitchenProfile\KitchenProfile as KitchenProfileEntity;
use App\Application\WaitTime\Entity\KitchenProfile\KitchenProfileRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<KitchenProfile>
 */
class KitchenProfileRepository extends ServiceEntityRepository implements KitchenProfileRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KitchenProfile::class);
    }

    public function save(KitchenProfileEntity $profile): int
    {
        $record = $profile->id !== null
            ? $this->find($profile->id)
            : new KitchenProfile();

        if ($record === null) {
            throw new \DomainException('Настройки кухни не найдены');
        }

        $record->setVenueId($profile->venueId);
        $record->setBaseMinutes($profile->baseMinutes);
        $record->setPerUnitMinutes($profile->perUnitMinutes);
        $record->setParallelCapacity($profile->parallelCapacity);
        $record->setDeliveryMinutes($profile->deliveryMinutes);
        $record->setCreatedAt($profile->createdAt);
        $record->setUpdatedAt($profile->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $profile->assignId($record->getId());

        return $record->getId();
    }

    public function findByVenueId(int $venueId): ?KitchenProfileEntity
    {
        $record = $this->findOneBy(['venueId' => $venueId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    private function toEntity(KitchenProfile $record): KitchenProfileEntity
    {
        return new KitchenProfileEntity(
            id: $record->getId(),
            venueId: $record->getVenueId(),
            baseMinutes: $record->getBaseMinutes(),
            perUnitMinutes: $record->getPerUnitMinutes(),
            parallelCapacity: $record->getParallelCapacity(),
            deliveryMinutes: $record->getDeliveryMinutes(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
