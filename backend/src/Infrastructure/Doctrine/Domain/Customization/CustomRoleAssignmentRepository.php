<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Customization;

use App\Application\Customization\Entity\CustomRoleAssignment\CustomRoleAssignment as CustomRoleAssignmentEntity;
use App\Application\Customization\Entity\CustomRoleAssignment\CustomRoleAssignmentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomRoleAssignment>
 */
class CustomRoleAssignmentRepository extends ServiceEntityRepository implements CustomRoleAssignmentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomRoleAssignment::class);
    }

    public function save(CustomRoleAssignmentEntity $assignment): int
    {
        $record = $assignment->id !== null
            ? $this->find($assignment->id)
            : new CustomRoleAssignment();

        if ($record === null) {
            throw new \DomainException('Назначение роли не найдено');
        }

        $record->setWorkspaceId($assignment->workspaceId);
        $record->setUserId($assignment->userId);
        $record->setRoleKey($assignment->roleKey);
        $record->setCreatedAt($assignment->createdAt);
        $record->setUpdatedAt($assignment->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $assignment->assignId($record->getId());

        return $record->getId();
    }

    public function findByWorkspaceUserAndRole(int $workspaceId, int $userId, string $roleKey): ?CustomRoleAssignmentEntity
    {
        $record = $this->findOneBy([
            'workspaceId' => $workspaceId,
            'userId' => $userId,
            'roleKey' => $roleKey,
        ]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function delete(int $assignmentId): void
    {
        $record = $this->find($assignmentId);

        if ($record === null) {
            return;
        }

        $this->getEntityManager()->remove($record);
        $this->getEntityManager()->flush();
    }

    public function roleKeysFor(int $workspaceId, int $userId): array
    {
        $records = $this->findBy(['workspaceId' => $workspaceId, 'userId' => $userId]);

        return array_values(array_map(
            static fn(CustomRoleAssignment $record): string => $record->getRoleKey(),
            $records,
        ));
    }

    private function toEntity(CustomRoleAssignment $record): CustomRoleAssignmentEntity
    {
        return new CustomRoleAssignmentEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            userId: $record->getUserId(),
            roleKey: $record->getRoleKey(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
