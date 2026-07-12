<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CreateAuthorizeTokens;

class CreateAuthorizeTokensCommand
{
    public function __construct(
        public readonly string $phone,
        public readonly int $userId,
        public readonly string $sessionId,
        public readonly bool $revokePreviousToken,
    ) {}
}
