<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Account;

interface LoyaltyAccountRepositoryInterface
{
    public function save(LoyaltyAccount $account): int;

    public function findByCustomer(int $workspaceId, int $customerId): ?LoyaltyAccount;

    public function getOrCreate(int $workspaceId, int $customerId): LoyaltyAccount;
}
