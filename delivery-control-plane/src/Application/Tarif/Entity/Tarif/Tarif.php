<?php

declare(strict_types=1);

namespace App\Application\Tarif\Entity\Tarif;

use Delivery\Contracts\Enum\TarifCodeEnum;

final class Tarif
{
    private function __construct(
        public ?int $id,
        public readonly TarifCodeEnum $code,
        public readonly string $name,
        public readonly string $description,
        public readonly int $price,
    ) {}

    public static function buildNew(TarifCodeEnum $code, string $name, string $description, int $price): self
    {
        return new self(
            id: null,
            code: $code,
            name: $name,
            description: $description,
            price: $price,
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}

