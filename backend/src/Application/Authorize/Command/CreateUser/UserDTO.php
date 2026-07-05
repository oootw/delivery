<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CreateUser;

class UserDTO
{
    public function __construct(
        public int $id,
        public string $phone,
    ) {}
}
