<?php

declare(strict_types=1);

namespace App\Custom\Acme\Settings;

use App\Application\Customization\Settings\SettingDefinition;
use App\Application\Customization\Settings\SettingsProviderInterface;
use App\Application\Customization\Settings\SettingType;

/**
 * Настройки модуля бронирования. Демонстрирует расширение поверхности настроек воркспейса
 * клиентским модулем — ключ префиксован slug'ом, чтобы не пересекаться с ядром/другими модулями.
 */
final class AcmeSettingsProvider implements SettingsProviderInterface
{
    public const LEAD_TIME_MINUTES = 'acme.reservations.lead_time_minutes';

    public function definitions(): array
    {
        return [
            new SettingDefinition(
                key: self::LEAD_TIME_MINUTES,
                type: SettingType::Int,
                default: 120,
                label: 'Минимальный запас до брони, минут',
                description: 'Бронь нельзя создать раньше, чем за это число минут до времени визита.',
            ),
        ];
    }
}
