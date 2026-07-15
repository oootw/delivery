<?php

declare(strict_types=1);

namespace App\Application\Subscription\Entity\OwnerSubscription;

interface OwnerSubscriptionRepositoryInterface
{
    public function save(OwnerSubscription $subscription): int;

    public function findCurrentByOwnerId(int $ownerId): ?OwnerSubscription;
}

