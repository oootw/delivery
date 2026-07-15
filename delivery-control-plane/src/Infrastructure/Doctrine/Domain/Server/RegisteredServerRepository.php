<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Server;

use App\Application\Server\Entity\RegisteredServer\RegisteredServer;
use App\Application\Server\Entity\RegisteredServer\RegisteredServerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RegisteredServerRecord>
 */
class RegisteredServerRepository extends ServiceEntityRepository implements RegisteredServerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegisteredServerRecord::class);
    }

    public function save(RegisteredServer $server): int
    {
        $record = $server->id !== null ? $this->find($server->id) : null;
        if ($record === null) {
            $record = new RegisteredServerRecord();
        }

        $record->setOwnerSlug($server->ownerSlug);
        $record->setDomain($server->domain);
        $record->setOwnerId($server->ownerId);
        $record->setWorkspaceId($server->workspaceId);
        $record->setServerToken($server->serverToken);
        $record->setCoreRef($server->coreRef);
        $record->setContractVersion($server->contractVersion);
        $record->setPinnedRef($server->pinnedRef);
        $record->setLastSeenAt($server->lastSeenAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $id = (int) $record->getId();
        if ($server->id === null) {
            $server->assignId($id);
        }

        return $id;
    }

    public function findByToken(string $serverToken): ?RegisteredServer
    {
        $record = $this->findOneBy(['serverToken' => $serverToken]);
        if ($record === null) {
            return null;
        }

        return $this->toEntity($record);
    }

    public function findByOwnerAndDomain(string $ownerSlug, string $domain): ?RegisteredServer
    {
        $record = $this->findOneBy([
            'ownerSlug' => $ownerSlug,
            'domain' => $domain,
        ]);
        if ($record === null) {
            return null;
        }

        return $this->toEntity($record);
    }

    public function findAll(): array
    {
        /** @var list<RegisteredServerRecord> $records */
        $records = $this->findBy([], ['id' => 'ASC']);

        return array_map($this->toEntity(...), $records);
    }

    private function toEntity(RegisteredServerRecord $record): RegisteredServer
    {
        $entity = RegisteredServer::buildNew(
            ownerSlug: $record->getOwnerSlug(),
            domain: $record->getDomain(),
            ownerId: $record->getOwnerId(),
            workspaceId: $record->getWorkspaceId(),
            serverToken: $record->getServerToken(),
            coreRef: $record->getCoreRef(),
            contractVersion: $record->getContractVersion(),
        );

        $id = $record->getId();
        if ($id !== null) {
            $entity->assignId($id);
        }

        if ($record->getPinnedRef() !== null) {
            $entity->pinTo($record->getPinnedRef());
        }

        $entity->markSeen($record->getCoreRef(), $record->getContractVersion());
        $entity->lastSeenAt = $record->getLastSeenAt();

        return $entity;
    }
}

