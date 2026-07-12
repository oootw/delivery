<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\FindUserByPhone;

class UserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $phone,
    ) {}
}
