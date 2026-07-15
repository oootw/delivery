<?php

declare(strict_types=1);

namespace App\Application\Release\Command\RegisterRelease;

final class RegisterReleaseCommand
{
    public function __construct(
        public readonly string $ref,
        public readonly string $contractVersion,
    ) {}
}

