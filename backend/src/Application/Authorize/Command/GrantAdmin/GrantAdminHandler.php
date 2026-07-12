<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\GrantAdmin;

use App\Application\Authorize\Entity\User\UserRepositoryInterface;
use App\Application\Authorize\Security\PasswordHasherInterface;

/**
 * Выдаёт пользователю права администратора и задаёт пароль для входа в админку.
 * Если пользователя с таким телефоном нет — создаёт его.
 */
class GrantAdminHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
        private readonly PasswordHasherInterface $passwordHasher,
    ) {}

    /** @return bool был ли создан новый пользователь */
    public function handle(GrantAdminCommand $command): bool
    {
        $created = false;

        if ($this->users->findByPhone($command->phone) === null) {
            $this->users->create($command->phone);
            $created = true;
        }

        $this->users->promoteToAdmin(
            phone: $command->phone,
            hashedPassword: $this->passwordHasher->hash($command->plainPassword),
        );

        return $created;
    }
}
