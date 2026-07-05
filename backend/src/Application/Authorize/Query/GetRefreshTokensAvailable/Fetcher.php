<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\GetRefreshTokensAvailable;

use App\Application\Authorize\Entity\Token\TokenRepositoryInterface;
use App\Shared\Service\JWTManager\Claims;
use App\Shared\Service\JWTManager\JWTManager;
use Webmozart\Assert\Assert;

class Fetcher
{
    public function __construct(
        private readonly JWTManager $jwtManager,
        private readonly TokenRepositoryInterface $tokens,
    ) {}

    public function fetch(Query $query): Claims
    {
        $claims = $this->jwtManager->validateRefreshToken($query->refreshToken);

        Assert::notNull($this->tokens->findTokenPairBySessionId($claims->sessionId), 'Сессия завершена');

        return $claims;
    }
}
