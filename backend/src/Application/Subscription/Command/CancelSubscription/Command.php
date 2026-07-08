<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\CancelSubscription;

class Command
{
    public function __construct(
        public readonly int $userId,
    ) {}
}
