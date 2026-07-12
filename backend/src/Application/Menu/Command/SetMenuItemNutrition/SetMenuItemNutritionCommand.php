<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\SetMenuItemNutrition;

use App\Application\Menu\Nutrition\Nutrition;

class SetMenuItemNutritionCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly int $venueId,
        public readonly int $itemId,
        public readonly Nutrition $nutrition,
    ) {}
}
