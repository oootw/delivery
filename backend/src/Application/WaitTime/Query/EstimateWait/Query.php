<?php

declare(strict_types=1);

namespace App\Application\WaitTime\Query\EstimateWait;

class Query
{
    public function __construct(
        public readonly int $venueId,
        public readonly string $type,
        /** Сколько единиц блюд гость планирует заказать. */
        public readonly int $units,
    ) {}
}
