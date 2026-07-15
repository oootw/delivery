<?php

declare(strict_types=1);

namespace App\Application\Server\Command\AcceptHeartbeat;

final class AcceptHeartbeatCommand
{
    public function __construct(
        public readonly string $serverToken,
        public readonly string $coreRef,
        public readonly string $contractVersion,
        public readonly string $healthStatus,
    ) {}
}

