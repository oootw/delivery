<?php

declare(strict_types=1);

namespace App\Application\Promotion\Query\GetPromotions;

class Query
{
    public function __construct(
        public readonly int $userId,
        public readonly int $workspaceId,
    ) {}
}
