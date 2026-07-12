<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\CancelSubscription;

class CancelSubscriptionCommand
{
    public function __construct(
        public readonly int $userId,
    ) {}
}
