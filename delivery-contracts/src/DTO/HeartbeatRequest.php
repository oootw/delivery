<?php

declare(strict_types=1);

namespace Delivery\Contracts\DTO;

final class HeartbeatRequest
{
    public function __construct(
        public readonly string $serverToken,
        public readonly string $coreRef,
        public readonly string $contractVersion,
        public readonly string $healthStatus,
    ) {}
}

