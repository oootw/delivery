<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\StopSubscription;

class StopSubscriptionCommand
{
    public function __construct(
        public readonly string $externalId,
    ) {}
}
