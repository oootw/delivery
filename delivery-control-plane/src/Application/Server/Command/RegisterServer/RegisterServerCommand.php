<?php

declare(strict_types=1);

namespace App\Application\Server\Command\RegisterServer;

final class RegisterServerCommand
{
    public function __construct(
        public readonly string $ownerSlug,
        public readonly string $domain,
        public readonly string $coreRef,
        public readonly string $contractVersion,
    ) {}
}

