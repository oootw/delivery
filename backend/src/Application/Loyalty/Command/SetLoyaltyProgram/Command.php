<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Command\SetLoyaltyProgram;

class Command
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly bool $isEnabled,
        public readonly int $earnRateBasisPoints,
        public readonly int $pointValueKopecks,
        public readonly int $redeemMaxPercentBasisPoints,
        public readonly ?int $pointsLifetimeDays,
    ) {}
}
