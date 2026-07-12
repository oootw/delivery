<?php

declare(strict_types=1);

namespace App\Custom\Acme;

use App\Application\Customization\Access\CustomRole;
use App\Application\Customization\Contract\AbstractCustomModule;

/**
 * Пилотный клиентский модуль (эталон-шаблон): демонстрирует сквозную кастомизацию —
 * своя сущность/эндпоинты (бронирование столов), кастомная роль, раздел админки и настройка.
 *
 * Поведение модуля бесплатно НЕ включается: он активен на воркспейсе только при записи в
 * workspace_custom_module (slug='acme'). capabilities() пуст — фича бесповеденческая
 * (гейтинг по активности модуля, а не по FeatureCodeEnum).
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
