<?php

declare(strict_types=1);

namespace App\Application\Server\Command\AcceptHeartbeat;

final class AcceptHeartbeatResult
{
    public function __construct(
        public readonly bool $accepted,
        public readonly ?string $targetCoreRef,
        public readonly bool $pinned,
    ) {}
}

