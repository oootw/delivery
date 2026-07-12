<?php

declare(strict_types=1);

namespace App\Application\Authorize\Events\OnAfterSaveNewUser;

use App\Application\Authorize\Entity\User\User;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Новый пользователь сохранён. Несёт доменную сущность User (не Doctrine — доменный слой
 * не должен зависеть от Infrastructure).
 */
class OnAfterSaveNewUserEvent extends Event
{
    public function __construct(
        private readonly User $user,
    ) {}

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): int
    {
        return $this->user->id;
    }
}
