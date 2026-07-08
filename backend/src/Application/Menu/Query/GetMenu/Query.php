<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetMenu;

class Query
{
    public function __construct(
        public readonly int $userId,
        public readonly int $venueId,
    ) {}
}
