<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\StartSubscription;

class Command
{
    public function __construct(
        public readonly int $userId,
        public readonly string $tarifCode,
    ) {}
}
