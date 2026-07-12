<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\PosIntegration;

use App\Application\PosIntegration\Entity\PosConnection\PosConnection as PosConnectionEntity;
use App\Application\PosIntegration\Entity\PosConnection\PosConnectionRepositoryInterface;
use App\Shared\Service\Crypto\SecretCipher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PosConnection>
 */
class PosConnectionRepository extends ServiceEntityRepository implements PosConnectionRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly SecretCipher $secretCipher,
    ) {
        parent::__construct($registry, PosConnection::class);
    }

    public function save(PosConnectionEntity $connection): int
    {
        $record = $connection->id !== null
            ? $this->find($connection->id)
            : new PosConnection();

        if ($record === null) {
            throw new \DomainException('POS-соединение не найдено');
        }

        $record->setVenueId($connection->venueId);
        $record->setPosSystem($connection->posSystem);
        $record->setApiLoginEncrypted($this->secretCipher->encrypt($connection->apiLogin));
        $record->setOrganizationId($connection->organizationId);
        $record->setExternalMenuId($connection->externalMenuId);
        $record->setStatus($connection->status);
        $record->setLastSyncedAt($connection->lastSyncedAt);
        $record->setLastError($connection->lastError);
        $record->setCreatedAt($connection->createdAt);
        $record->setUpdatedAt($connection->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $connection->assignId($record->getId());

        return $record->getId();
    }

    public function findById(int $id): ?PosConnectionEntity
    {
        $record = $this->find($id);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findByVenueId(int $venueId): ?PosConnectionEntity
    {
        $record = $this->findOneBy(['venueId' => $venueId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    private function toEntity(PosConnection $record): PosConnectionEntity
    {
        return new PosConnectionEntity(
            id: $record->getId(),
            venueId: $record->getVenueId(),
            posSystem: $record->getPosSystem(),
            apiLogin: $this->secretCipher->decrypt($record->getApiLoginEncrypted()),
            organizationId: $record->getOrganizationId(),
            externalMenuId: $record->getExternalMenuId(),
            status: $record->getStatus(),
            lastSyncedAt: $record->getLastSyncedAt(),
            lastError: $record->getLastError(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
