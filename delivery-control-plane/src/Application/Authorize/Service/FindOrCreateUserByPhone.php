<?php

declare(strict_types=1);

namespace App\Application\Authorize\Service;

use App\Application\Authorize\Entity\User\User;
use App\Application\Authorize\Entity\User\UserRepositoryInterface;

final class FindOrCreateUserByPhone
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    ) {}

    public function findOrCreate(string $phone, string $name): User
    {
        if ($phone === '') {
            throw new \DomainException('Телефон не может быть пустым');
        }

        $existing = $this->users->findByPhone($phone);
        if ($existing !== null) {
            return $existing;
        }

        $user = User::buildNew(
            phone: $phone,
            name: $name !== '' ? $name : $phone,
        );
        $this->users->save($user);

        return $user;
    }
}

