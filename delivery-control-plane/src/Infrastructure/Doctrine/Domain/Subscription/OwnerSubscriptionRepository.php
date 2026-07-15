<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Subscription;

use App\Application\Subscription\Entity\OwnerSubscription\OwnerSubscription;
use App\Application\Subscription\Entity\OwnerSubscription\OwnerSubscriptionRepositoryInterface;
use App\Application\Subscription\Entity\OwnerSubscription\OwnerSubscriptionStatusEnum;
use Delivery\Contracts\Enum\TarifCodeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OwnerSubscriptionRecord>
 */
class OwnerSubscriptionRepository extends ServiceEntityRepository implements OwnerSubscriptionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OwnerSubscriptionRecord::class);
    }

    public function save(OwnerSubscription $subscription): int
    {
        $record = $subscription->id !== null ? $this->find($subscription->id) : null;
        if ($record === null) {
            $record = new OwnerSubscriptionRecord();
        }

        $record->setOwnerId($subscription->ownerId);
        $record->setTarifCode($subscription->tarifCode->value);
        $record->setStatus($subscription->status->value);
        $record->setValidUntil($subscription->validUntil);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $id = (int) $record->getId();
        if ($subscription->id === null) {
            $subscription->assignId($id);
        }

        return $id;
    }

    public function findCurrentByOwnerId(int $ownerId): ?OwnerSubscription
    {
        $record = $this->findOneBy(['ownerId' => $ownerId]);
        if ($record === null) {
            return null;
        }

        try {
            $tarifCode = TarifCodeEnum::from($record->getTarifCode());
            $status = OwnerSubscriptionStatusEnum::from($record->getStatus());
        } catch (\ValueError) {
            return null;
        }

        $entity = OwnerSubscription::buildNew(
            ownerId: $record->getOwnerId(),
            tarifCode: $tarifCode,
            status: $status,
            validUntil: $record->getValidUntil(),
        );

        $id = $record->getId();
        if ($id !== null) {
            $entity->assignId($id);
        }

        return $entity;
    }
}

