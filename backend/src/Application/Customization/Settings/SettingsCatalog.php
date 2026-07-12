<?php

declare(strict_types=1);

namespace App\Application\Customization\Settings;

/**
 * Единый каталог объявленных настроек — собирает декларации всех поставщиков
 * (тег app.settings_provider) и валидирует «сырые» значения против них. Неизвестный ключ
 * задать нельзя: настройки — закрытый, объявленный в коде словарь.
 */
final class SettingsCatalog
{
    /** @var array<string, SettingDefinition>|null */
    private ?array $definitions = null;

    /**
     * @param iterable<SettingsProviderInterface> $providers
     */
    public function __construct(
        private readonly iterable $providers,
    ) {}

    /**
     * @return array<string, SettingDefinition>
     */
    public function all(): array
    {
        if ($this->definitions === null) {
            $this->definitions = [];

            foreach ($this->providers as $provider) {
                foreach ($provider->definitions() as $definition) {
                    if (isset($this->definitions[$definition->key])) {
                        throw new \LogicException(sprintf('Дублирующийся ключ настройки: %s', $definition->key));
                    }

                    $this->definitions[$definition->key] = $definition;
                }
            }
        }

        return $this->definitions;
    }

    public function get(string $key): ?SettingDefinition
    {
        return $this->all()[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($this->all()[$key]);
    }

    /**
     * Проверить и привести карту «сырых» значений к объявленным типам. Неизвестный ключ или
     * значение неверного типа → \DomainException.
     *
     * @param array<string, mixed> $raw
     * @return array<string, bool|int|string>
     */
    public function coerce(array $raw): array
    {
        $coerced = [];

        foreach ($raw as $key => $value) {
            $definition = $this->get($key);

            if ($definition === null) {
                throw new \DomainException(sprintf('Неизвестная настройка: %s', $key));
            }

            $coerced[$key] = $definition->coerce($value);
        }

        return $coerced;
    }
}
