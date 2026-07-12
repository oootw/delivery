<?php

declare(strict_types=1);

namespace App\Application\Customization\Registry;

use App\Application\Customization\Contract\CustomModuleInterface;
use App\Application\Customization\Entity\WorkspaceCustomModule\WorkspaceCustomModuleRepositoryInterface;

/**
 * Реестр клиентских модулей кастомизации. Собирает все реализации CustomModuleInterface
 * (тег app.custom_module) и сопоставляет их с активацией воркспейса (данные из
 * workspace_custom_module).
 *
 * Единственное место, через которое ядро «узнаёт» о кастоме — и то по тегу/данным, а не по
 * имени класса. Модуль без активной записи невидим (activeFor его не вернёт), даже если код
 * присутствует.
 *
 * Устойчивость к переименованию: активация сопоставляется по эффективному slug — текущему
 * (slug()) ИЛИ любому из previousSlugs(). Поэтому смена идентификатора модуля не «роняет»
 * существующие записи workspace_custom_module.
 */
final class CustomModuleRegistry
{
    /** @var array<string, CustomModuleInterface>|null индекс по текущему slug */
    private ?array $bySlug = null;

    /** @var array<string, CustomModuleInterface>|null индекс по эффективному slug (текущий ∪ прежние) */
    private ?array $byEffectiveSlug = null;

    /**
     * @param iterable<CustomModuleInterface> $modules
     */
    public function __construct(
        private readonly iterable $modules,
        private readonly WorkspaceCustomModuleRepositoryInterface $activation,
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

    /**
     * Активные на воркспейсе модули: пересечение включённых записей и зарегистрированного
     * кода (с учётом прежних slug). Записи без соответствующего кода игнорируются (модуль ещё
     * не задеплоен/удалён); дубли одного модуля через разные алиасы схлопываются.
     *
     * @return list<CustomModuleInterface>
     */
    public function activeFor(int $workspaceId): array
    {
        $this->index();

        $active = [];

        foreach ($this->activation->findEnabledSlugsByWorkspace($workspaceId) as $slug) {
            $module = $this->byEffectiveSlug[$slug] ?? null;

            if ($module !== null) {
                $active[$module->slug()] = $module;
            }
        }

        return array_values($active);
    }

    public function isActive(int $workspaceId, string $slug): bool
    {
        $this->index();

        $module = $this->byEffectiveSlug[$slug] ?? null;

        if ($module === null) {
            return false;
        }

        foreach ($this->activation->findEnabledSlugsByWorkspace($workspaceId) as $enabledSlug) {
            if (($this->byEffectiveSlug[$enabledSlug] ?? null) === $module) {
                return true;
            }
        }

        return false;
    }

    private function index(): void
    {
        if ($this->bySlug !== null) {
            return;
        }

        $this->bySlug = [];
        $this->byEffectiveSlug = [];

        foreach ($this->modules as $module) {
            $slug = $module->slug();

            if (isset($this->bySlug[$slug])) {
                throw new \LogicException(sprintf('Дублирующийся slug модуля кастомизации: %s', $slug));
            }

            $this->bySlug[$slug] = $module;

            foreach ([$slug, ...$module->previousSlugs()] as $effective) {
                if (isset($this->byEffectiveSlug[$effective]) && $this->byEffectiveSlug[$effective] !== $module) {
                    throw new \LogicException(sprintf('Конфликт slug модулей кастомизации: %s', $effective));
                }

                $this->byEffectiveSlug[$effective] = $module;
            }
        }
    }
}
