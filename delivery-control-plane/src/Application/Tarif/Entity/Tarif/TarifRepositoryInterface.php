<?php

declare(strict_types=1);

namespace App\Application\Tarif\Entity\Tarif;

use Delivery\Contracts\Enum\TarifCodeEnum;

interface TarifRepositoryInterface
{
    public function save(Tarif $tarif): int;

    public function findByCode(TarifCodeEnum $code): ?Tarif;

    /**
     * @return list<Tarif>
     */
    public function findAll(): array;
}

