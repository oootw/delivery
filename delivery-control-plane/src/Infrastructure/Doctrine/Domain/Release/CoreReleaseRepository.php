<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Release;

use App\Application\Release\Entity\CoreRelease\CoreRelease;
use App\Application\Release\Entity\CoreRelease\CoreReleaseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CoreReleaseRecord>
 */
class CoreReleaseRepository extends ServiceEntityRepository implements CoreReleaseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoreReleaseRecord::class);
    }

    public function save(CoreRelease $release): int
    {
        $record = $release->id !== null ? $this->find($release->id) : null;
        if ($record === null) {
            $record = new CoreReleaseRecord();
        }

        $record->setRef($release->ref);
        $record->setContractVersion($release->contractVersion);
        $record->setIsLatest($release->isLatest);
        $record->setCreatedAt($release->createdAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $id = (int) $record->getId();
        if ($release->id === null) {
            $release->assignId($id);
        }

        return $id;
    }

    public function findLatest(): ?CoreRelease
    {
        /** @var CoreReleaseRecord|null $record */
        $record = $this->findOneBy(['isLatest' => true], ['id' => 'DESC']);
        if ($record === null) {
            return null;
        }

        return $this->toEntity($record);
    }

    public function clearLatestFlag(): void
    {
        $this->createQueryBuilder('r')
            ->update()
            ->set('r.isLatest', ':isLatest')
            ->setParameter('isLatest', false)
            ->getQuery()
            ->execute();
    }

    private function toEntity(CoreReleaseRecord $record): CoreRelease
    {
        $entity = CoreRelease::buildNew(
            ref: $record->getRef(),
            contractVersion: $record->getContractVersion(),
        );
        $entity->isLatest = $record->isLatest();
        $entity->restoreCreatedAt($record->getCreatedAt());

        $id = $record->getId();
        if ($id !== null) {
            $entity->assignId($id);
        }

        return $entity;
    }
}

