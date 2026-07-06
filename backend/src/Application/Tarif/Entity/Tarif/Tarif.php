<?php

declare(strict_types=1);

namespace App\Application\Tarif\Entity\Tarif;

use App\Shared\Enum\Feature\FeatureCodeEnum;

class Tarif
{
    public function __construct(
        public ?int $id,
        public TarifCodeEnum $tarifCode,
        public string $name,
        public string $description,
        public int $price,

        /** @var FeatureCodeEnum[] */
        public array $features,
    ) {}

    public static function buildNew(
        string $name,
        TarifCodeEnum $tarifCode,
        string $description,
        int $price,

        /** @var FeatureCodeEnum[] */
        array $features,
    ): self {
        return new self(
            id: null,
            tarifCode: $tarifCode,
            name: $name,
            description: $description,
            price: $price,
            features: $features,
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
