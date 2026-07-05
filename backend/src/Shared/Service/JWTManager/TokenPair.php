<?php

declare(strict_types=1);

namespace App\Shared\Service\JWTManager;

class TokenPair
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken,
        public string $sessionId,
        public int $expiresIn,
    ) {}
}
