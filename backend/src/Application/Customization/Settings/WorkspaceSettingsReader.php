<?php

declare(strict_types=1);

namespace App\Application\Customization\Settings;

use App\Application\Customization\Entity\WorkspaceSettings\WorkspaceSettingsRepositoryInterface;

/**
 * Типизированное чтение настроек воркспейса: сохранённое значение, иначе значение по умолчанию
 * из каталога, приведённое к объявленному типу. Ключ, не объявленный в каталоге, — ошибка
 * (читать «неизвестную» настройку нельзя). Это точка, которой ядро и клиентский код спрашивают
 * конфиг воркспейса.
 */
final class WorkspaceSettingsReader
{
    public function __construct(
        private readonly SettingsCatalog $catalog,
        private readonly WorkspaceSettingsRepositoryInterface $repository,
    ) {}

    public function get(int $workspaceId, string $key): bool|int|string
    {
        $definition = $this->catalog->get($key);

        if ($definition === null) {
            throw new \DomainException(sprintf('Неизвестная настройка: %s', $key));
        }

        $stored = $this->repository->findByWorkspace($workspaceId)?->get($key);

        if ($stored === null) {
            return $definition->default;
        }

        return $definition->coerce($stored);
    }

    public function bool(int $workspaceId, string $key): bool
    {
        $this->assertType($key, SettingType::Bool);

        return (bool) $this->get($workspaceId, $key);
    }

    public function int(int $workspaceId, string $key): int
    {
        $this->assertType($key, SettingType::Int);

        return (int) $this->get($workspaceId, $key);
    }

    public function string(int $workspaceId, string $key): string
    {
        $this->assertType($key, SettingType::Str);

        return (string) $this->get($workspaceId, $key);
    }

    private function assertType(string $key, SettingType $expected): void
    {
        $definition = $this->catalog->get($key);

        if ($definition === null) {
            throw new \DomainException(sprintf('Неизвестная настройка: %s', $key));
        }

        if ($definition->type !== $expected) {
            throw new \DomainException(sprintf(
                'Настройка «%s» имеет тип %s, запрошен %s',
                $key,
                $definition->type->value,
                $expected->value,
            ));
        }
    }
}
