<?php

declare(strict_types=1);

namespace App\Shared\Service\JWTManager;

class Claims
{
    public function __construct(
        public int $userId,
        public string $phone,
        public string $sessionId,
    ) {}
}
