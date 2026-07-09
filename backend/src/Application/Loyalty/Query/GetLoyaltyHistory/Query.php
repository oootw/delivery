<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Query\GetLoyaltyHistory;

class Query
{
    public function __construct(
        public readonly int $userId,
        public readonly int $workspaceId,
        public readonly int $limit = 50,
    ) {}
}
