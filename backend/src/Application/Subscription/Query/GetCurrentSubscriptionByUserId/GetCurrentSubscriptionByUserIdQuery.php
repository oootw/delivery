<?php

declare(strict_types=1);

namespace App\Application\Subscription\Query\GetCurrentSubscriptionByUserId;

class GetCurrentSubscriptionByUserIdQuery
{
    public function __construct(
        public readonly int $userId,
    ) {}
}
