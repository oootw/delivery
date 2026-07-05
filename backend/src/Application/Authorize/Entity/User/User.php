<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\User;

class User
{
    public function __construct(
        public readonly int $id,
    ) {}

    public static function buildNew(int $id): self
    {
        return new self(
            id: $id,
        );
    }
}
