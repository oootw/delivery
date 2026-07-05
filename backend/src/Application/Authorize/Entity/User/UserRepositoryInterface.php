<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\User;

interface UserRepositoryInterface
{
    public function findByPhone(string $phone): ?User;

    public function create(string $phone): int;
}
