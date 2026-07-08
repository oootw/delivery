<?php

declare(strict_types=1);

namespace App\Application\Order\Command\ChangeOrderStatus;

class Command
{
    public function __construct(
        public readonly int $orderId,
        public readonly int $actingUserId,
        public readonly string $newStatus,
    ) {}
}
