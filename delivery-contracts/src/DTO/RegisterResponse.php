<?php

declare(strict_types=1);

namespace Delivery\Contracts\DTO;

final class RegisterResponse
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly string $serverToken,
    ) {}
}

