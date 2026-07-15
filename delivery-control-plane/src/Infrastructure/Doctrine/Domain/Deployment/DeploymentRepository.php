<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Deployment;

use App\Application\Deployment\Entity\Deployment\Deployment;
use App\Application\Deployment\Entity\Deployment\DeploymentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeploymentRecord>
 */
class DeploymentRepository extends ServiceEntityRepository implements DeploymentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeploymentRecord::class);
    }

    public function save(Deployment $deployment): int
    {
        $record = new DeploymentRecord();
        $record->setKind($deployment->kind);
        $record->setReleaseRef($deployment->releaseRef);
        $record->setInitiator($deployment->initiator);
        $record->setTargetHost($deployment->targetHost);
        $record->setStatus($deployment->status);
        $record->setCreatedAt($deployment->createdAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $id = (int) $record->getId();
        $deployment->assignId($id);

        return $id;
    }
}

