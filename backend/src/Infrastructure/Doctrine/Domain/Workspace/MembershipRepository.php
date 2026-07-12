<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Workspace;

use App\Application\Workspace\Entity\Membership\Membership as MembershipEntity;
use App\Application\Workspace\Entity\Membership\MembershipRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Membership>
 */
class MembershipRepository extends ServiceEntityRepository implements MembershipRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membership::class);
    }

    public function save(MembershipEntity $membership): int
    {
        $record = $membership->id !== null
            ? $this->find($membership->id)
            : new Membership();

        if ($record === null) {
            throw new \DomainException('Членство не найдено');
        }

        $record->setWorkspaceId($membership->workspaceId);
        $record->setUserId($membership->userId);
        $record->setRole($membership->role);
        $record->setCreatedAt($membership->createdAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $membership->assignId($record->getId());

        return $record->getId();
    }

    public function findByWorkspaceAndUser(int $workspaceId, int $userId): ?MembershipEntity
    {
        $record = $this->findOneBy([
            'workspaceId' => $workspaceId,
            'userId' => $userId,
        ]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    /**
     * @return MembershipEntity[]
     */
    public function findAllByUserId(int $userId): array
    {
        return array_map(
            fn(Membership $record): MembershipEntity => $this->toEntity($record),
            $this->findBy(['userId' => $userId]),
        );
    }

    public function delete(int $membershipId): void
    {
        $record = $this->find($membershipId);

        if ($record === null) {
            return;
        }

        $this->getEntityManager()->remove($record);
        $this->getEntityManager()->flush();
    }

    private function toEntity(Membership $record): MembershipEntity
    {
        return new MembershipEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            userId: $record->getUserId(),
            role: $record->getRole(),
            createdAt: $record->getCreatedAt(),
        );
    }
}
