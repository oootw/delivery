<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Authorize;

use App\Application\Authorize\Entity\User\User;
use App\Application\Authorize\Entity\User\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserRecord>
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserRecord::class);
    }

    public function save(User $user): int
    {
        $record = $user->id !== null ? $this->find($user->id) : null;
        if ($record === null) {
            $record = new UserRecord();
        }

        $record->setPhone($user->phone);
        $record->setName($user->name);
        $record->setIsAdmin($user->isAdmin);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $id = (int) $record->getId();
        if ($user->id === null) {
            $user->assignId($id);
        }

        return $id;
    }

    public function findByPhone(string $phone): ?User
    {
        $record = $this->findOneBy(['phone' => $phone]);
        if ($record === null) {
            return null;
        }

        return $this->toEntity($record);
    }

    public function findById(int $id): ?User
    {
        $record = $this->find($id);
        if ($record === null) {
            return null;
        }

        return $this->toEntity($record);
    }

    private function toEntity(UserRecord $record): User
    {
        $entity = User::buildNew(
            phone: $record->getPhone(),
            name: $record->getName(),
            isAdmin: $record->isAdmin(),
        );

        $id = $record->getId();
        if ($id !== null) {
            $entity->assignId($id);
        }

        return $entity;
    }
}

