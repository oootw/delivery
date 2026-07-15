<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetClientProductsByCategoryId;

class GetClientProductsByCategoryIdQuery
{
    public function __construct(
        public readonly int $workspaceId,
        public readonly int $venueId,
        public readonly int $categoryId,
    ) {}
}
