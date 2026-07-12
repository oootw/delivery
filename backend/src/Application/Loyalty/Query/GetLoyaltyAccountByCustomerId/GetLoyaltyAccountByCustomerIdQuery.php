<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Query\GetLoyaltyAccountByCustomerId;

class GetLoyaltyAccountByCustomerIdQuery
{
    public function __construct(
        public readonly int $userId,
        public readonly int $workspaceId,
    ) {}
}
