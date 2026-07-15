<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Tarif;

use App\Application\Tarif\Entity\Tarif\Tarif;
use App\Application\Tarif\Entity\Tarif\TarifRepositoryInterface;
use Delivery\Contracts\Enum\TarifCodeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TarifRecord>
 */
class TarifRepository extends ServiceEntityRepository implements TarifRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TarifRecord::class);
    }

    public function save(Tarif $tarif): int
    {
        $record = $tarif->id !== null ? $this->find($tarif->id) : null;
        if ($record === null) {
            $record = new TarifRecord();
        }

        $record->setCode($tarif->code->value);
        $record->setName($tarif->name);
        $record->setDescription($tarif->description);
        $record->setPrice($tarif->price);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $id = (int) $record->getId();
        if ($tarif->id === null) {
            $tarif->assignId($id);
        }

        return $id;
    }

    public function findByCode(TarifCodeEnum $code): ?Tarif
    {
        $record = $this->findOneBy(['code' => $code->value]);
        if ($record === null) {
            return null;
        }

        return $this->toEntity($record);
    }

    public function findAll(): array
    {
        /** @var list<TarifRecord> $records */
        $records = $this->findBy([], ['id' => 'ASC']);

        return array_map($this->toEntity(...), $records);
    }

    private function toEntity(TarifRecord $record): Tarif
    {
        $entity = Tarif::buildNew(
            code: TarifCodeEnum::from($record->getCode()),
            name: $record->getName(),
            description: $record->getDescription(),
            price: $record->getPrice(),
        );

        $id = $record->getId();
        if ($id !== null) {
            $entity->assignId($id);
        }

        return $entity;
    }
}

