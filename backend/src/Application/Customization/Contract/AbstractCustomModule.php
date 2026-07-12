<?php

declare(strict_types=1);

namespace App\Application\Customization\Contract;

/**
 * Базовый класс клиентского модуля с разумными значениями по умолчанию. Модулю достаточно
 * задать slug() и title(); previousSlugs()/capabilities() переопределяются по необходимости.
 */
abstract class AbstractCustomModule implements CustomModuleInterface
{
    public function previousSlugs(): array
    {
        return [];
    }

    public function capabilities(): array
    {
        return [];
    }

    public function roles(): array
    {
        return [];
    }
}
