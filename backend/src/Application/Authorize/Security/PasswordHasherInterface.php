<?php

declare(strict_types=1);

namespace App\Application\Authorize\Security;

/**
 * Порт хэширования паролей (для входа админа в панель). Реализация — в Infrastructure
 * поверх Symfony PasswordHasher; домен не знает про алгоритм/фреймворк.
 */
interface PasswordHasherInterface
{
    public function hash(string $plainPassword): string;
}
