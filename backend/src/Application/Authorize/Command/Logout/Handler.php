<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\Logout;

use App\Application\Authorize\Entity\Token\TokenRepositoryInterface;

class Handler
{
    public function __construct(
        private readonly TokenRepositoryInterface $tokens,
    ) {}

    public function handle(Command $command): void
    {
        $this->tokens->revokeTokensByUserSessionId($command->userId);
    }
}
