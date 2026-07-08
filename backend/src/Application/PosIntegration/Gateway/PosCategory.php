<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Gateway;

final class PosCategory
{
    /**
     * @param PosItem[] $items
     */
    public function __construct(
        public readonly string $externalId,
        public readonly string $name,
        public readonly int $position,
        public readonly array $items,
    ) {}
}
