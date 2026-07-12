<?php

declare(strict_types=1);

namespace App\Application\Customization\Settings;

/**
 * Декларация одной настройки воркспейса: ключ, тип, значение по умолчанию и подписи для UI.
 * Схема настроек живёт в коде (провайдеры), а значения per-workspace — в данных: сменить
 * значение клиенту можно без деплоя, добавить новую настройку — небольшой глобальный код.
 */
final class SettingDefinition
{
    public function __construct(
        public readonly string $key,
        public readonly SettingType $type,
        public readonly bool|int|string $default,
        public readonly string $label,
        public readonly string $description = '',
    ) {
        if (trim($key) === '') {
            throw new \DomainException('Ключ настройки не может быть пустым');
        }

        // default обязан соответствовать типу — иначе провайдер объявил несогласованную настройку.
        $this->coerce($default);
    }

    /**
     * Привести «сырое» значение к объявленному типу или бросить \DomainException. Bool терпит
     * 0/1, Int запрещает bool (в PHP true == 1), Str требует строку.
     */
    public function coerce(mixed $value): bool|int|string
    {
        return match ($this->type) {
            SettingType::Bool => $this->coerceBool($value),
            SettingType::Int => $this->coerceInt($value),
            SettingType::Str => $this->coerceString($value),
        };
    }

    private function coerceBool(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if ($value === 0 || $value === 1) {
            return $value === 1;
        }

        throw new \DomainException(sprintf('Настройка «%s» ожидает булево значение', $this->key));
    }

    private function coerceInt(mixed $value): int
    {
        if (is_int($value) && !is_bool($value)) {
            return $value;
        }

        throw new \DomainException(sprintf('Настройка «%s» ожидает целое число', $this->key));
    }

    private function coerceString(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        throw new \DomainException(sprintf('Настройка «%s» ожидает строку', $this->key));
    }
}
