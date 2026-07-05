<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\Token;

use DateTime;

class Token
{
    public function __construct(
        public ?string $sessionId,
        public int $userId,
        public string $refreshToken,
        public int $expiresAt,
        public DateTime $createdAt,
    ) {}

    public static function buildNew(
        string $sessionId,
        int $userId,
        string $refreshToken,
        int $expiresAt,
        DateTime $createdAt,
    ): self {
        return new self(
            sessionId: $sessionId,
            userId: $userId,
            refreshToken: $refreshToken,
            expiresAt: $expiresAt,
            createdAt: $createdAt,
        );
    }
}
