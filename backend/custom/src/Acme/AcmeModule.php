<?php

declare(strict_types=1);

namespace App\Custom\Acme;

use App\Application\Customization\Access\CustomRole;
use App\Application\Customization\Contract\AbstractCustomModule;

/**
 * Пилотный клиентский модуль (эталон-шаблон): демонстрирует сквозную кастомизацию —
 * своя сущность/эндпоинты (бронирование столов), кастомная роль, раздел админки и настройка.
 *
 * В single-tenant модели сервер содержит один набор модулей, поэтому данный модуль активен,
 * если его код присутствует в оверлее. capabilities() пуст — фича бесповеденческая
 * (гейтинг по роли, а не по FeatureCodeEnum).
 */
final class AcmeModule extends AbstractCustomModule
{
    public const SLUG = 'acme';
    public const ROLE_RESERVATION_MANAGER = 'acme.reservation_manager';

    public function slug(): string
    {
        return self::SLUG;
    }

    public function title(): string
    {
        return 'Acme (бронирование столов)';
    }

    public function roles(): array
    {
        return [
            new CustomRole(self::ROLE_RESERVATION_MANAGER, 'Менеджер бронирований'),
        ];
    }
}
