<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\FindUserByPhone;

use App\Application\Authorize\Entity\User\UserRepositoryInterface;

class FindUserByPhoneFetcher
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    ) {}

    public function fetch(FindUserByPhoneQuery $query): ?UserDTO
    {
        $user = $this->users->findByPhone($query->phone);

        return $user ? new UserDTO(id: $user->id, phone: $user->phone) : null;
    }
}
