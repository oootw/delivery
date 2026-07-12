<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\MenuItemNutrition;

use App\Application\Menu\Nutrition\Nutrition;

/**
 * Ручной оверрайд пищевой ценности товара. Хранится отдельно от MenuItem и не
 * затрагивается импортом из POS. Привязан к товару по (venueId, itemExternalId).
 */
class MenuItemNutrition
{
    public function __construct(
        public ?int $id,
        public int $venueId,
        public string $itemExternalId,
        public Nutrition $nutrition,
    ) {}

    public static function buildNew(int $venueId, string $itemExternalId, Nutrition $nutrition): self
    {
        return new self(
            id: null,
            venueId: $venueId,
            itemExternalId: $itemExternalId,
            nutrition: $nutrition,
        );
    }

    public function change(Nutrition $nutrition): void
    {
        $this->nutrition = $nutrition;
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
