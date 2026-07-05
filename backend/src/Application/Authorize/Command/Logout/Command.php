<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\Logout;

class Command
{
    public function __construct(
        public readonly int $userId,
    ) {}
}
