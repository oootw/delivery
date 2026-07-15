<?php

declare(strict_types=1);

namespace App\Application\Authorize\Service;

use App\Application\Authorize\Entity\User\User;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

final class IssueJwtToken
{
    private readonly Configuration $jwtConfig;

    public function __construct(string $jwtSecret)
    {
        $this->jwtConfig = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($jwtSecret),
        );
    }

    public function issue(User $user): string
    {
        $now = new \DateTimeImmutable();
        $expiresAt = $now->modify('+2 hours');

        $builder = $this->jwtConfig->builder()
            ->issuedBy('delivery-control-plane')
            ->issuedAt($now)
            ->expiresAt($expiresAt)
            ->withClaim('userId', $user->id)
            ->withClaim('phone', $user->phone)
            ->withClaim('isAdmin', $user->isAdmin);

        $token = $builder->getToken(
            $this->jwtConfig->signer(),
            $this->jwtConfig->signingKey(),
        );

        return $token->toString();
    }
}

