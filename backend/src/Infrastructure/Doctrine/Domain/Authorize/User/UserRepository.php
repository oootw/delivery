<?php

namespace App\Infrastructure\Doctrine\Domain\Authorize\User;

use App\Application\Authorize\Entity\User\User as EntityUser;
use App\Application\Authorize\Entity\User\UserRepositoryInterface;
use App\Application\Authorize\Events\OnAfterSaveNewUser\OnAfterSaveNewUserEvent;
use App\Application\Authorize\Events\OnBeforeSaveNewUser\OnBeforeSaveNewUserEvent;
use App\Infrastructure\Doctrine\Domain\Authorize\User\User;
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

        return $user ? EntityUser::buildNew(id: $user->getId(), phone: $phone) : null;
    }

    public function create(string $phone): int
    {
        $user = new User();
        $user->setPhone($phone);
        $user->setFullName('');
        $user->setBrithDate(new \DateTime('1970-01-01'));
        $user->setIsActive(true);
        $user->setCreatedAt(new \DateTimeImmutable());

        $this->dispatcher->dispatch(
            new OnBeforeSaveNewUserEvent(
                phone: $phone,
            )
        );

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        $this->dispatcher->dispatch(
            new OnAfterSaveNewUserEvent(
                user: EntityUser::buildNew(id: $user->getId(), phone: $phone),
            )
        );

        return $user->getId();
    }

    public function promoteToAdmin(string $phone, string $hashedPassword): void
    {
        $user = $this->findOneBy(['phone' => $phone]);

        if ($user === null) {
            throw new \DomainException('Пользователь не найден');
        }

        $user->setIsAdmin(true);
        $user->setPassword($hashedPassword);

        $this->getEntityManager()->flush();
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
