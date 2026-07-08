<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\ModifierGroup;

/**
 * Группа модификаторов (например, «Соусы»). minSelection/maxSelection — правила выбора.
 */
class ModifierGroup
{
    public function __construct(
        public ?int $id,
        public int $venueId,
        public string $externalId,
        public string $name,
        public int $minSelection,
        public int $maxSelection,
        public bool $isArchived,
    ) {}

    public static function buildNew(
        int $venueId,
        string $externalId,
        string $name,
        int $minSelection,
        int $maxSelection,
    ): self {
        return new self(
            id: null,
            venueId: $venueId,
            externalId: $externalId,
            name: $name,
            minSelection: $minSelection,
            maxSelection: $maxSelection,
            isArchived: false,
        );
    }

    public function applyFromPos(string $name, int $minSelection, int $maxSelection): void
    {
        $this->name = $name;
        $this->minSelection = $minSelection;
        $this->maxSelection = $maxSelection;
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
