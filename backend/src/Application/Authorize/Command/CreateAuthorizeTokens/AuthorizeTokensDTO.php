<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CreateAuthorizeTokens;

class AuthorizeTokensDTO
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken,
        public int $expiresIn,
    ) {}
}
