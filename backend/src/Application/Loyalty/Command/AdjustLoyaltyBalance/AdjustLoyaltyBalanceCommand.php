<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Command\AdjustLoyaltyBalance;

class AdjustLoyaltyBalanceCommand
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly int $customerId,
        public readonly int $deltaPoints,
        public readonly ?string $comment,
    ) {}
}
