<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Gateway;

use App\Application\Menu\Nutrition\Nutrition;

final class PosItem
{
    /**
     * @param string[] $modifierGroupExternalIds
     */
    public function __construct(
        public readonly string $externalId,
        public readonly string $categoryExternalId,
        public readonly string $name,
        public readonly string $description,
        public readonly int $priceKopecks,
        public readonly ?string $imageUrl,
        public readonly bool $isAvailable,
        public readonly int $position,
        public readonly array $modifierGroupExternalIds,
        public readonly ?Nutrition $nutrition = null,
    ) {}
}
