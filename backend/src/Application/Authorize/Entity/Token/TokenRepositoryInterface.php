<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\Token;

use App\Application\Authorize\Entity\Token\Token;

interface TokenRepositoryInterface
{
    function findTokenPairBySessionId(string $sessionId): ?Token;

    function revokeTokensByUserSessionId(int $userId): void;

    function isSessionActive(string $sessionId): bool;

    function revokeTokensBySessionId(string $sessionId): void;

    function save(Token $token): void;
}
