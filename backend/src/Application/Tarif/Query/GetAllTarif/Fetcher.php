<?php

declare(strict_types=1);

namespace App\Application\Tarif\Query\GetAllTarif;

use App\Application\Tarif\Entity\Tarif\Tarif;
use App\Application\Tarif\Entity\Tarif\TarifRepositoryInterface;

class Fetcher
{
    public function __construct(
        private readonly TarifRepositoryInterface $tarifs,
    ) {}

    public function fetch(): array
    {
        return array_map(
            fn(Tarif $tarif): TarifDTO => new TarifDTO(
                id: $tarif->getId(),
                tarifCode: $tarif->tarifCode->value,
                name: $tarif->name,
                description: $tarif->description,
                price: $tarif->price,
                features: $tarif->features,
            ),
            $this->tarifs->getAll()
        );
    }
}
