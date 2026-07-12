<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CreateUser;

class CreateUserCommand
{
    public function __construct(
        public readonly string $phone,
    ) {}
}
