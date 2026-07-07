<?php

declare(strict_types=1);

namespace App\Application\Users\Entity\User;

interface UserRepositoryInterface
{
    public function findById(int $id): void;
}
