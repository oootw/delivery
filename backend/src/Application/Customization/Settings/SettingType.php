<?php

declare(strict_types=1);

namespace App\Application\Customization\Settings;

/**
 * Тип значения настройки воркспейса. Определяет, как «сырое» значение (из JSON-тела запроса
 * или хранилища) приводится и валидируется. Скалярные типы намеренно ограничены — настройки
 * должны оставаться простыми данными.
 */
enum SettingType: string
{
    case Bool = 'bool';
    case Int = 'int';
    case Str = 'string';
}
