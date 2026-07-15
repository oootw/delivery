<?php

declare(strict_types=1);

namespace App\Http\Security;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Exception;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

final class JwtTokenValidator
{
    private readonly Configuration $jwtConfig;

    public function __construct(
        string $jwtSecret,
    ) {
        $this->jwtConfig = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($jwtSecret),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function validate(string $token): array
    {
        if ($token === '') {
            throw new \DomainException('JWT-токен не передан');
        }

        try {
            $parsed = $this->jwtConfig->parser()->parse($token);
        } catch (Exception) {
            throw new \DomainException('JWT-токен повреждён или имеет неверный формат');
        }

        $isValid = $this->jwtConfig->validator()->validate(
            $parsed,
            new SignedWith($this->jwtConfig->signer(), $this->jwtConfig->verificationKey()),
            new LooseValidAt(new \DateTimeZone('UTC')),
        );

        if (!$isValid) {
            throw new \DomainException('JWT-токен не прошёл валидацию');
        }

        return $parsed->claims()->all();
    }
}

