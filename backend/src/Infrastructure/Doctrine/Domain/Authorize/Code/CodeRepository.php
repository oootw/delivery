<?php

namespace App\Infrastructure\Doctrine\Domain\Authorize\Code;

use App\Application\Authorize\Entity\Code\Code as EntityCode;
use App\Application\Authorize\Entity\Code\CodeRepositoryInterface;
use App\Application\Authorize\Entity\Code\CodeTypeEnum;
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

    public function findActiveCode(string $phone, CodeTypeEnum $codeType): ?EntityCode
    {
        $code = $this->createQueryBuilder('c')
            ->where('c.phone = :phone')
            ->andWhere('c.codeType = :codeType')
            ->setParameter('phone', $phone)
            ->setParameter('codeType', $codeType->value)
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if ($code === null) {
            return null;
        }

        return new EntityCode(
            id: $code->getId(),
            phone: $code->getPhone(),
            code: $code->getCode(),
            codeType: $code->getCodeType(),
            expiresAt: $code->getExpiresAt(),
            usedAt: $code->getUsedAt(),
            attempts: $code->getAttempts(),
        );
    }

    public function hasRecentCode(string $phone, \DateTimeImmutable $since): bool
    {
        $count = (int) $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.phone = :phone')
            ->andWhere('c.createdAt >= :since')
            ->setParameter('phone', $phone)
            ->setParameter('since', $since)
            ->getQuery()
            ->getSingleScalarResult();

        return $count > 0;
    }

    public function countCreatedSince(string $phone, \DateTime $since): int
    {
        return (int) $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.phone = :phone')
            ->andWhere('c.createdAt >= :since')
            ->setParameter('phone', $phone)
            ->setParameter('since', \DateTimeImmutable::createFromMutable($since))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function save(EntityCode $entityCode): void
    {
        $code = $this->find($entityCode->id);

        if ($code === null) {
            throw new \DomainException('Код авторизации не найден для сохранения');
        }

        $code->setAttempts($entityCode->attempts);
        $code->setUsedAt($entityCode->usedAt);

        $this->getEntityManager()->flush();
    }

    /** Срок жизни кода авторизации. */
    private const CODE_TTL = '+5 minutes';

    public function create(EntityCode $entityCode): int
    {
        $now = new \DateTimeImmutable();

        $code = new Code();

        $code->setCode($entityCode->code);
        $code->setPhone($entityCode->phone);
        $code->setCodeType($entityCode->codeType);
        $code->setCreatedAt($now);
        $code->setExpiresAt($now->modify(self::CODE_TTL));

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
