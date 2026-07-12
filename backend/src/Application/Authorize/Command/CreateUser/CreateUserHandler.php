<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CreateUser;

use App\Application\Authorize\Entity\User\UserRepositoryInterface;

class CreateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    ) {}

    public function handle(CreateUserCommand $command): UserDTO
    {
        $userId = $this->users->create($command->phone);

        return new UserDTO(
            id: $userId,
            phone: $command->phone,
        );
    }
}
