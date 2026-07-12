<?php

declare(strict_types=1);

namespace App\Application\Authorize\Events\OnBeforeSaveNewUser;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Пользователь вот-вот будет создан. Диспатчится до сохранения (id ещё нет), поэтому
 * несёт только известные до записи данные — телефон.
 */
class OnBeforeSaveNewUserEvent extends Event
{
    public function __construct(
        public readonly string $phone,
    ) {}

    public function getPhone(): string
    {
        return $this->phone;
    }
}
