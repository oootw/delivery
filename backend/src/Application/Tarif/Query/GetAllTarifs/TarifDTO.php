<?php

declare(strict_types=1);

namespace App\Application\Tarif\Query\GetAllTarifs;

class TarifDTO
{
    public function __construct(
        public int $id,
        public string $tarifCode,
        public string $name,
        public string $description,
        public int $price,
        public array $features,
    ) {}
}
