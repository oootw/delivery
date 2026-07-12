<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\Logout;

class LogoutCommand
{
    public function __construct(
        public readonly int $userId,
    ) {}
}
