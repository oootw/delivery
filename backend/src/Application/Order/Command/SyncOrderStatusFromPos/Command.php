<?php

declare(strict_types=1);

namespace App\Application\Order\Command\SyncOrderStatusFromPos;

class Command
{
    public function __construct(
        public readonly int $orderId,
        public readonly string $newStatus,
    ) {}
}
