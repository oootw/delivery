<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetClientProductById;

class GetClientProductByIdQuery
{
    public function __construct(
        public readonly string $workspaceSlug,
        public readonly int $venueId,
        public readonly int $itemId,
    ) {}
}
