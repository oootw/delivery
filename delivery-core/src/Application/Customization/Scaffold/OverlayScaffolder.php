<?php

declare(strict_types=1);

namespace App\Application\Customization\Scaffold;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class OverlayScaffolder
{
    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
    ) {
    }

    public function scaffold(
        string $ownerSlug,
        string $ownerClass,
        string $moduleSlug,
        string $moduleClass,
        string $coreContract,
        bool $force,
    ): OverlayScaffoldResult {
        $overlayRoot = $this->projectDir . '/custom';
        $this->assertWritableOverlayPath($overlayRoot, $force);

        $files = [
            $overlayRoot . '/manifest.json' => $this->manifestTemplate($ownerSlug, $moduleSlug, $coreContract),
            $overlayRoot . '/composer.json' => $this->composerTemplate(),
            $overlayRoot . '/README.md' => $this->readmeTemplate($ownerSlug, $moduleSlug, $ownerClass, $moduleClass),
            $overlayRoot . '/config/services.yaml' => $this->servicesTemplate(),
            $overlayRoot . '/config/routes.yaml' => $this->routesTemplate(),
            $overlayRoot . '/src/.gitkeep' => '',
            $overlayRoot . '/tests/.gitkeep' => '',
            $overlayRoot . '/migrations/.gitkeep' => '',
            $overlayRoot . '/src/' . $ownerClass . '/' . $ownerClass . 'Module.php' => $this->moduleTemplate($ownerClass, $moduleClass, $moduleSlug),
            $overlayRoot . '/src/' . $ownerClass . '/Settings/' . $ownerClass . 'SettingsProvider.php' => $this->settingsProviderTemplate($ownerClass, $moduleClass, $moduleSlug),
        ];

        $created = [];
        $updated = [];
        $unchanged = [];

        foreach ($files as $path => $content) {
            $this->ensureParentDirectory($path);

            if (!is_file($path)) {
                file_put_contents($path, $content);
                $created[] = $this->relativePath($path);
                continue;
            }

            $current = (string) file_get_contents($path);
            if ($current === $content) {
                $unchanged[] = $this->relativePath($path);
                continue;
            }

            if (!$force) {
                throw new \RuntimeException(sprintf(
                    'Файл уже существует и отличается: %s. Повторите с --force для перезаписи.',
                    $this->relativePath($path),
                ));
            }

            file_put_contents($path, $content);
            $updated[] = $this->relativePath($path);
        }

        return new OverlayScaffoldResult($created, $updated, $unchanged);
    }

    private function assertWritableOverlayPath(string $overlayRoot, bool $force): void
    {
        if (!is_dir($overlayRoot)) {
            return;
        }

        $entries = array_values(array_diff((array) scandir($overlayRoot), ['.', '..']));
        if ($entries === []) {
            return;
        }

        if ($force) {
            return;
        }

        throw new \RuntimeException('Директория custom/ уже заполнена. Используйте --force для перегенерации.');
    }

    private function ensureParentDirectory(string $path): void
    {
        $parent = dirname($path);
        if (!is_dir($parent)) {
            mkdir($parent, 0o755, true);
        }
    }

    private function relativePath(string $path): string
    {
        $prefix = rtrim($this->projectDir, '/') . '/';
        if (str_starts_with($path, $prefix)) {
            return substr($path, strlen($prefix));
        }

        return $path;
    }

    private function manifestTemplate(string $ownerSlug, string $moduleSlug, string $coreContract): string
    {
        return json_encode(
            [
                'owner' => $ownerSlug,
                'core_contract' => $coreContract,
                'modules' => [$moduleSlug],
                'notes' => sprintf('Overlay владельца %s', $ownerSlug),
            ],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
        ) . PHP_EOL;
    }

    private function composerTemplate(): string
    {
        return <<<JSON
{
    "autoload": {
        "psr-4": {
            "App\\\\Custom\\\\": "src/"
        }
    }
}
JSON . PHP_EOL;
    }

    private function servicesTemplate(): string
    {
        return <<<YAML
services:
    _defaults:
        autowire: true
        autoconfigure: true

    App\Custom\:
        resource: '../src/'
        exclude: '../src/**/{Entity,Migrations,Tests}'
YAML . PHP_EOL;
    }

    private function routesTemplate(): string
    {
        return <<<YAML
custom_controllers:
    resource: '../src/'
    type: attribute
    prefix: /api/v1
YAML . PHP_EOL;
    }

    private function moduleTemplate(string $ownerClass, string $moduleClass, string $moduleSlug): string
    {
        return <<<PHP
<?php

declare(strict_types=1);

namespace App\Custom\\{$ownerClass};

/**
 * Базовый шаблон модуля overlay.
 * Заполните роли/настройки/точки расширения под требования владельца.
 */
final class {$ownerClass}Module
{
    public const SLUG = '{$moduleSlug}';
    public const TITLE = '{$moduleClass} module';
    public const ROLE_MANAGER = '{$moduleSlug}.manager';
}
PHP . PHP_EOL;
    }

    private function settingsProviderTemplate(string $ownerClass, string $moduleClass, string $moduleSlug): string
    {
        return <<<PHP
<?php

declare(strict_types=1);

namespace App\Custom\\{$ownerClass}\Settings;

/**
 * Заготовка провайдера настроек overlay.
 * Замените массив на реальную реализацию SettingsProviderInterface после подключения слоёв кастомизации ядра.
 */
final class {$ownerClass}SettingsProvider
{
    /**
     * @return array<string, mixed>
     */
    public function definitions(): array
    {
        return [
            '{$moduleSlug}.enabled' => [
                'type' => 'bool',
                'default' => true,
                'label' => '{$moduleClass}: включено',
            ],
        ];
    }
}
PHP . PHP_EOL;
    }

    private function readmeTemplate(string $ownerSlug, string $moduleSlug, string $ownerClass, string $moduleClass): string
    {
        return <<<MD
# Overlay: {$ownerSlug}

Сгенерировано командой `php bin/console app:custom:new {$ownerSlug}`.

## Что создано

- `manifest.json` с owner/module/core_contract;
- каркас `App\\Custom\\{$ownerClass}\\{$ownerClass}Module`;
- базовый `{$ownerClass}SettingsProvider`;
- `config/services.yaml` и `config/routes.yaml`.

## Следующие шаги

1. Доработать бизнес-код в `custom/src/`.
2. Проверить overlay: `php bin/console app:custom:doctor`.
3. Проверить совместимость контракта: `php bin/console app:custom:check-compat`.
4. Задеплоить overlay через `delivery-infra/playbooks/custom-deploy.yml` или общий `release.yml`.

## Текущий модуль

- owner: `{$ownerSlug}`
- module slug: `{$moduleSlug}`
- module title: `{$moduleClass}`
MD . PHP_EOL;
    }
}
