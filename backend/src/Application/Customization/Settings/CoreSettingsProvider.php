<?php

declare(strict_types=1);

namespace App\Application\Customization\Settings;

/**
 * Глобальные настройки воркспейса, доступные всем подписчикам. Сюда добавляются
 * общие тумблеры/параметры ядра по мере появления. Пока пусто: механизм готов, конкретные
 * настройки заводятся под реальный запрос (глобальные — здесь, клиентские — в своём модуле).
 */
final class CoreSettingsProvider implements SettingsProviderInterface
{
    public function definitions(): array
    {
        return [];
    }
}
