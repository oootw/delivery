<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\Logout;

use App\Application\Authorize\Entity\Token\TokenRepositoryInterface;

class LogoutHandler
{
    public function __construct(
        private readonly TokenRepositoryInterface $tokens,
    ) {}

    public function handle(LogoutCommand $command): void
    {
        $this->tokens->revokeTokensByUserSessionId($command->userId);
    }
}
