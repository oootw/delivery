<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): int;

    public function findByPhone(string $phone): ?User;

    public function findById(int $id): ?User;
}

