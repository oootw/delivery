<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Gateway;

final class PosModifierGroup
{
    /**
     * @param PosModifier[] $modifiers
     */
    public function __construct(
        public readonly string $externalId,
        public readonly string $name,
        public readonly int $minSelection,
        public readonly int $maxSelection,
        public readonly array $modifiers,
    ) {}
}
