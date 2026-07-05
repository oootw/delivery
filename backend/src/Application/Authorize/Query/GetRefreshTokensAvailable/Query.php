<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\GetRefreshTokensAvailable;

class Query
{
    public function __construct(
        public readonly string $refreshToken,
    ) {}
}
