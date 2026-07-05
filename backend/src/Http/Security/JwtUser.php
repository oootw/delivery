<?php

declare(strict_types=1);

namespace App\Http\Security;

use App\Shared\Service\JWTManager\Claims;
use Symfony\Component\Security\Core\User\UserInterface;

class JwtUser implements UserInterface
{
    public function __construct(
        public readonly Claims $claims,
    ) {}

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void {}

    public function getUserIdentifier(): string
    {
        return (string) $this->claims->userId;
    }
}
