<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\MarkSubscriptionPastDue;

class Command
{
    public function __construct(
        public readonly string $externalId,
    ) {}
}
