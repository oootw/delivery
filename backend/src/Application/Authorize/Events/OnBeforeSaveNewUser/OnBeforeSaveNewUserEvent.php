<?php

declare(strict_types=1);

namespace App\Application\Authorize\Events\OnBeforeSaveNewUser;

use App\Infrastructure\Doctrine\Domain\Users\User;
use Symfony\Contracts\EventDispatcher\Event;

class OnBeforeSaveNewUserEvent extends Event
{
    public function __construct(private User $user) {}

    public function getUser(): User
    {
        return $this->user;
    }
}
