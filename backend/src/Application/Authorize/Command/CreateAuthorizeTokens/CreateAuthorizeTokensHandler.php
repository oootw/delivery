<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CreateAuthorizeTokens;

use App\Application\Authorize\Entity\Token\Token;
use App\Application\Authorize\Entity\Token\TokenRepositoryInterface;
use App\Shared\Service\JWTManager\JWTManager;
use DateTime;
use Symfony\Component\Uid\Uuid;

class CreateAuthorizeTokensHandler
{
    public function __construct(
        private readonly TokenRepositoryInterface $tokens,
        private readonly JWTManager $jwtManager,
    ) {}

    public function handle(CreateAuthorizeTokensCommand $command): AuthorizeTokensDTO
    {
        if ($command->revokePreviousToken && $command->sessionId !== '') {
            $this->tokens->revokeTokensBySessionId($command->sessionId);
        }

        $sessionId = Uuid::v4()->toRfc4122();

        $pair = $this->jwtManager->generateTokenPair(
            userId: $command->userId,
            phone: $command->phone,
            sessionId: $sessionId,
        );

        $this->tokens->save(
            Token::buildNew(
                sessionId: $sessionId,
                userId: $command->userId,
                refreshToken: $pair->refreshToken,
                expiresAt: $this->jwtManager->refreshExpiresAtUnix(),
                createdAt: new DateTime(),
            ),
        );

        return new AuthorizeTokensDTO(
            accessToken: $pair->accessToken,
            refreshToken: $pair->refreshToken,
            expiresIn: $pair->expiresIn,
        );
    }
}
