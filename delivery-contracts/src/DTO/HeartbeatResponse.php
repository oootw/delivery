<?php

declare(strict_types=1);

namespace Delivery\Contracts\DTO;

final class HeartbeatResponse
{
    public function __construct(
        public readonly bool $accepted,
        public readonly ?string $targetCoreRef,
        public readonly bool $pinned,
    ) {}
}

