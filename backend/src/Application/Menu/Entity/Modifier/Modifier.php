<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\Modifier;

/**
 * Модификатор внутри группы (например, «Кетчуп»). Цена в копейках.
 */
class Modifier
{
    public function __construct(
        public ?int $id,
        public int $venueId,
        public string $externalId,
        public string $modifierGroupExternalId,
        public string $name,
        public int $priceKopecks,
        public bool $isArchived,
    ) {}

    public static function buildNew(
        int $venueId,
        string $externalId,
        string $modifierGroupExternalId,
        string $name,
        int $priceKopecks,
    ): self {
        return new self(
            id: null,
            venueId: $venueId,
            externalId: $externalId,
            modifierGroupExternalId: $modifierGroupExternalId,
            name: $name,
            priceKopecks: $priceKopecks,
            isArchived: false,
        );
    }

    public function applyFromPos(string $modifierGroupExternalId, string $name, int $priceKopecks): void
    {
        $this->modifierGroupExternalId = $modifierGroupExternalId;
        $this->name = $name;
        $this->priceKopecks = $priceKopecks;
        $this->isArchived = false;
    }

    public function archive(): void
    {
        $this->isArchived = true;
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
