<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Redemption;

interface LoyaltyRedemptionRepositoryInterface
{
    public function save(LoyaltyRedemption $redemption): int;

    public function findByOrder(int $orderId): ?LoyaltyRedemption;
}
