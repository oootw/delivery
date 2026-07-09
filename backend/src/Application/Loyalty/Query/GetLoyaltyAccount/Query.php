<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Query\GetLoyaltyAccount;

class Query
{
    public function __construct(
        public readonly int $userId,
        public readonly int $workspaceId,
    ) {}
}
