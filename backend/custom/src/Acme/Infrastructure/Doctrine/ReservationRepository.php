<?php

declare(strict_types=1);

namespace App\Custom\Acme\Infrastructure\Doctrine;

use App\Custom\Acme\Reservation\Reservation as ReservationEntity;
use App\Custom\Acme\Reservation\ReservationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository implements ReservationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(ReservationEntity $reservation): int
    {
        $record = $reservation->id !== null
            ? $this->find($reservation->id)
            : new Reservation();

        if ($record === null) {
            throw new \DomainException('Бронь не найдена');
        }

        $record->setWorkspaceId($reservation->workspaceId);
        $record->setVenueId($reservation->venueId);
        $record->setGuestName($reservation->guestName);
        $record->setGuestPhone($reservation->guestPhone);
        $record->setPeopleCount($reservation->peopleCount);
        $record->setDesiredAt($reservation->desiredAt);
        $record->setCreatedAt($reservation->createdAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $reservation->assignId($record->getId());

        return $record->getId();
    }

    public function findByWorkspace(int $workspaceId): array
    {
        $records = $this->findBy(['workspaceId' => $workspaceId], ['desiredAt' => 'ASC']);

        return array_map(
            fn(Reservation $record): ReservationEntity => $this->toEntity($record),
            $records,
        );
    }

    private function toEntity(Reservation $record): ReservationEntity
    {
        return new ReservationEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            venueId: $record->getVenueId(),
            guestName: $record->getGuestName(),
            guestPhone: $record->getGuestPhone(),
            peopleCount: $record->getPeopleCount(),
            desiredAt: $record->getDesiredAt(),
            createdAt: $record->getCreatedAt(),
        );
    }
}
