<?php

declare(strict_types=1);

namespace App\Application\Subscription\Query\GetCurrentSubscriptionByUserId;

class SubscriptionDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $tarifCode,
        public readonly string $status,
        public readonly bool $isActive,
        public readonly ?string $currentPeriodEnd,
    ) {}
}
