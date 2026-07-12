<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\User;

/**
 * Доменная идентичность пользователя: id + телефон (естественный ключ/логин). Профиль,
 * флаги (isActive/isAdmin) и пароль здесь не моделируются — у них нет доменных потребителей,
 * а учётные данные/права админки — концерн Infrastructure/Security (Doctrine-сущность User).
 */
class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $phone,
    ) {}

    public static function buildNew(int $id, string $phone): self
    {
        return new self(
            id: $id,
            phone: $phone,
        );
    }
}
