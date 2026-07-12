<?php

declare(strict_types=1);

namespace App\Application\Customization\Settings;

/**
 * Поставщик деклараций настроек. Ядро объявляет глобальные настройки (CoreSettingsProvider),
 * клиентские модули — свои. Реализации помечаются тегом app.settings_provider и собираются
 * SettingsCatalog. Так кастом-модуль расширяет поверхность настроек воркспейса, не трогая ядро.
 */
interface SettingsProviderInterface
{
    /**
     * @return list<SettingDefinition>
     */
    public function definitions(): array;
}
