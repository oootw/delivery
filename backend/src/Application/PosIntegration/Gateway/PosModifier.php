<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Gateway;

final class PosModifier
{
    public function __construct(
        public readonly string $externalId,
        public readonly string $name,
        public readonly int $priceKopecks,
    ) {}
}
