<?php

declare(strict_types=1);

namespace App\Application\Customization\Access;

/**
 * Роль, которую объявляет клиентский модуль поверх базовых Owner/Staff. Ключ стабилен и
 * уникален в пределах модуля (рекомендуется префикс slug'ом, напр. «acme.reservation_manager»),
 * label — для UI/админки. Проверяется через CustomAccess::hasRole.
 */
final class CustomRole
{
    public function __construct(
        public readonly string $key,
        public readonly string $label,
    ) {
        if (trim($key) === '') {
            throw new \DomainException('Ключ роли не может быть пустым');
        }
    }
}
