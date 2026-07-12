<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\CreateCombo;

use App\Application\Menu\Entity\Combo\ComboDiscountTypeEnum;
use App\Application\Menu\Entity\Combo\ComboItem;

class CreateComboCommand
{
    /**
     * @param ComboItem[] $items
     */
    public function __construct(
        public readonly int $userId,
        public readonly int $venueId,
        public readonly string $name,
        public readonly string $description,
        public readonly ComboDiscountTypeEnum $discountType,
        public readonly int $discountValue,
        public readonly array $items,
        public readonly int $position,
        public readonly bool $isAvailable,
    ) {}
}
