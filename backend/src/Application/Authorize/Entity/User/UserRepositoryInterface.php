<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\User;

interface UserRepositoryInterface
{
    public function findByPhone(string $phone): ?User;

    public function create(string $phone): int;

    /** Выдать права администратора и задать хэш пароля для входа в админку. */
    public function promoteToAdmin(string $phone, string $hashedPassword): void;
}
