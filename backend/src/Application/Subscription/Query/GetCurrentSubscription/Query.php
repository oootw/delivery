<?php

declare(strict_types=1);

namespace App\Application\Subscription\Query\GetCurrentSubscription;

class Query
{
    public function __construct(
        public readonly int $userId,
    ) {}
}
