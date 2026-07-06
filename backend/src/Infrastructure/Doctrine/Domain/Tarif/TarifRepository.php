<?php

namespace App\Infrastructure\Doctrine\Domain\Tarif;

use App\Application\Tarif\Entity\Tarif\Tarif as TarifEntity;
use App\Application\Tarif\Entity\Tarif\TarifCodeEnum;
use App\Application\Tarif\Entity\Tarif\TarifRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tarif>
 */
class TarifRepository extends ServiceEntityRepository implements TarifRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tarif::class);
    }

    /** @return TarifEntity[] */
    public function getAll(): array
    {
        $tarifs = $this->findAll();

        if ($tarifs === null) {
            throw new \DomainException('Тарифы не найдены');
        }

        return array_map(
            fn(Tarif $tarif) => new TarifEntity(
                id: $tarif->getId(),
                tarifCode: $tarif->getTarifCode(),
                name: $tarif->getName(),
                description: $tarif->getDescription(),
                price: $tarif->getPrice(),
                features: [],
            ),
            $tarifs
        );
    }

    //    /**
    //     * @return Tarif[] Returns an array of Tarif objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tarif
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
