<?php

namespace App\Infrastructure\Doctrine\Domain\Authorize\Code;

use App\Application\Authorize\Entity\Code\Code as EntityCode;
use App\Application\Authorize\Entity\Code\CodeRepositoryInterface;
use App\Infrastructure\Doctrine\Domain\Authorize\Code\Code;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Code>
 */
class CodeRepository extends ServiceEntityRepository implements CodeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Code::class);
    }

    public function validateCodeByCreatedAt(string $phone): bool
    {
        return true;
    }

    public function countCreatedSince(string $phone, \DateTime $since): int
    {
        return 0;
    }

    public function validateCode(EntityCode $code): bool
    {
        return true;
    }

    public function create(EntityCode $entityCode): int
    {
        $code = new Code();

        $code->setCode($entityCode->code);
        $code->setPhone($entityCode->phone);
        $code->setCodeType($entityCode->codeType);

        $this->getEntityManager()->persist($code);
        $this->getEntityManager()->flush();

        return $code->getId();
    }

//    /**
//     * @return Code[] Returns an array of Code objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Code
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
