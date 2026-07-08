<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Venue;

use App\Application\Venue\Entity\Venue\Venue as VenueEntity;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Venue\Entity\Venue\WorkingHours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Venue>
 */
class VenueRepository extends ServiceEntityRepository implements VenueRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Venue::class);
    }

    public function save(VenueEntity $venue): int
    {
        $record = $venue->id !== null
            ? $this->find($venue->id)
            : new Venue();

        if ($record === null) {
            throw new \DomainException('Точка не найдена');
        }

        $record->setWorkspaceId($venue->workspaceId);
        $record->setName($venue->name);
        $record->setAddress($venue->address);
        $record->setLatitude($venue->latitude);
        $record->setLongitude($venue->longitude);
        $record->setPhone($venue->phone);
        $record->setSupportsDelivery($venue->supportsDelivery);
        $record->setSupportsPickup($venue->supportsPickup);
        $record->setDeliveryRadiusMeters($venue->deliveryRadiusMeters);
        $record->setWorkingHours($venue->workingHours->toArray());
        $record->setIsActive($venue->isActive);
        $record->setCreatedAt($venue->createdAt);
        $record->setUpdatedAt($venue->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $venue->assignId($record->getId());

        return $record->getId();
    }

    public function findById(int $id): ?VenueEntity
    {
        $record = $this->find($id);

        return $record !== null ? $this->toEntity($record) : null;
    }

    /**
     * @return VenueEntity[]
     */
    public function findAllByWorkspace(int $workspaceId): array
    {
        return array_map(
            fn(Venue $record): VenueEntity => $this->toEntity($record),
            $this->findBy(['workspaceId' => $workspaceId], ['id' => 'ASC']),
        );
    }

    private function toEntity(Venue $record): VenueEntity
    {
        return new VenueEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            name: $record->getName(),
            address: $record->getAddress(),
            latitude: $record->getLatitude(),
            longitude: $record->getLongitude(),
            phone: $record->getPhone(),
            supportsDelivery: $record->isSupportsDelivery(),
            supportsPickup: $record->isSupportsPickup(),
            deliveryRadiusMeters: $record->getDeliveryRadiusMeters(),
            workingHours: WorkingHours::fromArray($record->getWorkingHours()),
            isActive: $record->isActive(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
