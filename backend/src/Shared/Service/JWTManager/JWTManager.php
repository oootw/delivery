<?php

declare(strict_types=1);

namespace App\Shared\Service\JWTManager;

use DateTimeImmutable;
use InvalidArgumentException;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Psr\Clock\ClockInterface;
use Throwable;

class JWTManager
{
    private readonly Sha256 $signer;
    private readonly InMemory $signingKey;
    private readonly JwtFacade $jwt;
    private readonly ClockInterface $clock;

    public function __construct(
        private readonly string $secret,
        private readonly int $accessTtl,
        private readonly int $refreshTtl,
    ) {
        $this->signer = new Sha256();
        $this->signingKey = InMemory::plainText($secret);
        $this->clock = new readonly class implements ClockInterface {
            public function now(): DateTimeImmutable
            {
                return new DateTimeImmutable();
            }
        };
        $this->jwt = new JwtFacade(clock: $this->clock);
    }

    public function generateTokenPair(int $userId, string $phone, string $sessionId): TokenPair
    {
        return new TokenPair(
            accessToken: $this->createToken($userId, $phone, $sessionId, $this->accessTtl),
            refreshToken: $this->createToken($userId, $phone, $sessionId, $this->refreshTtl),
            sessionId: $sessionId,
            expiresIn: $this->accessTtl,
        );
    }

    public function refreshExpiresAtUnix(): int
    {
        return time() + $this->refreshTtl;
    }

    public function validateRefreshToken(string $token): Claims
    {
        return $this->validateToken($token);
    }

    public function validateAccessToken(string $token): Claims
    {
        return $this->validateToken($token);
    }

    private function createToken(int $userId, string $phone, string $sessionId, int $ttl): string
    {
        try {
            $token = $this->jwt->issue(
                $this->signer,
                $this->signingKey,
                function (Builder $builder, DateTimeImmutable $issuedAt) use ($userId, $phone, $sessionId, $ttl): Builder {
                    return $builder
                        ->expiresAt($issuedAt->modify('+' . $ttl . ' seconds'))
                        ->relatedTo((string) $userId)
                        ->withClaim('user_id', $userId)
                        ->withClaim('phone', $phone)
                        ->withClaim('session_id', $sessionId);
                },
            );
        } catch (Throwable) {
            throw new InvalidArgumentException(JWTManagerErrorEnum::FAILED_TO_GENERATE_TOKEN->value);
        }

        return $token->toString();
    }

    private function validateToken(string $tokenString): Claims
    {
        try {
            $token = $this->jwt->parse(
                $tokenString,
                new SignedWith($this->signer, $this->signingKey),
                new StrictValidAt($this->clock),
            );
        } catch (RequiredConstraintsViolated) {
            throw new InvalidArgumentException(JWTManagerErrorEnum::INVALID_TOKEN->value);
        } catch (Throwable) {
            throw new InvalidArgumentException(JWTManagerErrorEnum::FAILED_TO_PARSE_TOKEN->value);
        }

        return $this->extractClaims($token);
    }

    private function extractClaims(UnencryptedToken $token): Claims
    {
        $userId = $token->claims()->get('user_id');
        $phone = $token->claims()->get('phone');
        $sessionId = $token->claims()->get('session_id');

        if (!is_int($userId) || !is_string($phone) || !is_string($sessionId)) {
            throw new InvalidArgumentException(JWTManagerErrorEnum::INVALID_TOKEN->value);
        }

        return new Claims(
            userId: $userId,
            phone: $phone,
            sessionId: $sessionId,
        );
    }
}
