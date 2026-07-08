<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\Category;

/**
 * Категория меню точки. externalId — идентификатор в POS-системе, по нему идёт upsert.
 * Исчезнувшие из POS категории архивируются, а не удаляются.
 */
class Category
{
    public function __construct(
        public ?int $id,
        public int $venueId,
        public string $externalId,
        public string $name,
        public int $position,
        public bool $isArchived,
    ) {}

    public static function buildNew(int $venueId, string $externalId, string $name, int $position): self
    {
        return new self(
            id: null,
            venueId: $venueId,
            externalId: $externalId,
            name: $name,
            position: $position,
            isArchived: false,
        );
    }

    public function applyFromPos(string $name, int $position): void
    {
        $this->name = $name;
        $this->position = $position;
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
