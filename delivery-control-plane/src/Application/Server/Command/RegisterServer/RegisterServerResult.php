<?php

declare(strict_types=1);

namespace App\Application\Server\Command\RegisterServer;

final class RegisterServerResult
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly string $serverToken,
    ) {}
}

