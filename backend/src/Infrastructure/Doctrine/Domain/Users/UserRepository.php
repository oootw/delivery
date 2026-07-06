<?php

namespace App\Infrastructure\Doctrine\Domain\Users;

use App\Application\Authorize\Entity\User\User as EntityUser;
use App\Application\Authorize\Entity\User\UserRepositoryInterface;
use App\Application\Authorize\Events\CreateNewUserEvent\CreateNewUserEvent;
use App\Application\Authorize\Events\CreateNewUserEvent\CreateNewUserEventPayload;
use App\Infrastructure\Doctrine\Domain\Users\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    private EventDispatcherInterface $dispatcher;

    public function __construct(ManagerRegistry $registry, EventDispatcherInterface $dispatcher)
    {
        parent::__construct($registry, User::class);

        $this->dispatcher = $dispatcher;
    }

    public function findByPhone(string $phone): ?EntityUser
    {
        $user = $this->createQueryBuilder('u')
            ->andWhere('u.phone = :phone')
            ->setParameter('phone', $phone)
            ->getQuery()
            ->getOneOrNullResult();

        return $user ? EntityUser::buildNew($user->getId()) : null;
    }

    public function create(string $phone): int
    {
        $user = new User();
        $user->setPhone($phone);
        $user->setFullName('');
        $user->setBrithDate(new \DateTime('1970-01-01'));
        $user->setIsActive(true);
        $user->setCreatedAt(new \DateTimeImmutable());

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        $this->dispatcher->dispatch(
            new CreateNewUserEvent(
                new CreateNewUserEventPayload(
                    userId: $user->getId(),
                    phone: $user->getPhone(),
                    name: $user->getFullName(),
                    createdAt: $user->getCreatedAt(),
                    birthDate: $user->getBrithDate(),
                )
            )
        );

        return $user->getId();
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
