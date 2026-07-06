<?php

declare(strict_types=1);

namespace App\Application\Tarif\Entity\Tarif;

interface TarifRepositoryInterface
{
    /**
     * @return Tarif[]
     */
    public function getAll(): array;

    public function getByTarifCode(TarifCodeEnum $tarifCode): ?Tarif;
}
