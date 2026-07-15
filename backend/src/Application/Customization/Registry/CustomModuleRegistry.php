<?php

declare(strict_types=1);

namespace App\Application\Customization\Registry;

use App\Application\Customization\Contract\CustomModuleInterface;

/**
 * Реестр клиентских модулей кастомизации. Собирает все реализации CustomModuleInterface
 * (тег app.custom_module). В single-tenant модели сервера все обнаруженные модули считаются
 * активными.
 */
final class CustomModuleRegistry
{
    /** @var array<string, CustomModuleInterface>|null индекс по текущему slug */
    private ?array $bySlug = null;

    /**
     * @param iterable<CustomModuleInterface> $modules
     */
    public function __construct(
        private readonly iterable $modules,
    ) {}

    /**
     * Все зарегистрированные модули, индексированные по текущему slug.
     *
     * @return array<string, CustomModuleInterface>
     */
    public function all(): array
    {
        $this->index();

        return $this->bySlug;
    }

    public function get(string $slug): ?CustomModuleInterface
    {
        return $this->all()[$slug] ?? null;
    }

    public function has(string $slug): bool
    {
        return isset($this->all()[$slug]);
    }

    private function index(): void
    {
        if ($this->bySlug !== null) {
            return;
        }

        $this->bySlug = [];

        foreach ($this->modules as $module) {
            $slug = $module->slug();

            if (isset($this->bySlug[$slug])) {
                throw new \LogicException(sprintf('Дублирующийся slug модуля кастомизации: %s', $slug));
            }

            $this->bySlug[$slug] = $module;
        }
    }
}
