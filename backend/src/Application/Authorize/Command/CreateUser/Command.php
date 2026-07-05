<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CreateUser;

class Command
{
    public function __construct(
        public readonly string $phone,
    ) {}
}
