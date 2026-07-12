<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Command\SetLoyaltyTiers;

class SetLoyaltyTiersCommand
{
    /**
     * @param list<array{
     *     name: string,
     *     threshold_kopecks: int,
     *     earn_rate_bonus_basis_points: int,
     *     permanent_discount_basis_points: int,
     *     sort_order: int
     * }> $tiers
     */
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly array $tiers,
    ) {}
}
