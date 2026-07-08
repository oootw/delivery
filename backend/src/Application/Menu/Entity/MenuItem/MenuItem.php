<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\MenuItem;

/**
 * Позиция меню. Цена в копейках. isAvailable отражает стоп-лист POS,
 * isArchived — что позиция исчезла из выгрузки POS.
 */
class MenuItem
{
    public function __construct(
        public ?int $id,
        public int $venueId,
        public string $externalId,
        public string $categoryExternalId,
        public string $name,
        public string $description,
        public int $priceKopecks,
        public ?string $imageUrl,
        public bool $isAvailable,
        public int $position,
        /** @var string[] */
        public array $modifierGroupExternalIds,
        public bool $isArchived,
    ) {}

    /**
     * @param string[] $modifierGroupExternalIds
     */
    public static function buildNew(
        int $venueId,
        string $externalId,
        string $categoryExternalId,
        string $name,
        string $description,
        int $priceKopecks,
        ?string $imageUrl,
        bool $isAvailable,
        int $position,
        array $modifierGroupExternalIds,
    ): self {
        return new self(
            id: null,
            venueId: $venueId,
            externalId: $externalId,
            categoryExternalId: $categoryExternalId,
            name: $name,
            description: $description,
            priceKopecks: $priceKopecks,
            imageUrl: $imageUrl,
            isAvailable: $isAvailable,
            position: $position,
            modifierGroupExternalIds: $modifierGroupExternalIds,
            isArchived: false,
        );
    }

    /**
     * @param string[] $modifierGroupExternalIds
     */
    public function applyFromPos(
        string $categoryExternalId,
        string $name,
        string $description,
        int $priceKopecks,
        ?string $imageUrl,
        bool $isAvailable,
        int $position,
        array $modifierGroupExternalIds,
    ): void {
        $this->categoryExternalId = $categoryExternalId;
        $this->name = $name;
        $this->description = $description;
        $this->priceKopecks = $priceKopecks;
        $this->imageUrl = $imageUrl;
        $this->isAvailable = $isAvailable;
        $this->position = $position;
        $this->modifierGroupExternalIds = $modifierGroupExternalIds;
        $this->isArchived = false;
    }

    public function archive(): void
    {
        $this->isArchived = true;
        $this->isAvailable = false;
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
