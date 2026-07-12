<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\GrantAdmin;

class GrantAdminCommand
{
    public function __construct(
        public readonly string $phone,
        public readonly string $plainPassword,
    ) {}
}
