<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use App\Application\Authorize\Security\PasswordHasherInterface;
use App\Infrastructure\Doctrine\Domain\Authorize\User\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Адаптер хэширования пароля поверх Symfony PasswordHasher. Пустой экземпляр User нужен
 * лишь чтобы хэшер выбрал алгоритм по классу пользователя (поля не читаются).
 */
final class AdminPasswordHasher implements PasswordHasherInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function hash(string $plainPassword): string
    {
        return $this->passwordHasher->hashPassword(new User(), $plainPassword);
    }
}
