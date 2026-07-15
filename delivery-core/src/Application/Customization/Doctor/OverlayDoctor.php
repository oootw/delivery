<?php

declare(strict_types=1);

namespace App\Application\Customization\Doctor;

use Composer\Semver\Semver;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class OverlayDoctor
{
    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
    ) {
    }

    public function run(): DoctorReport
    {
        $report = new DoctorReport();
        $customDir = $this->projectDir . '/custom';
        $manifestPath = $customDir . '/manifest.json';
        $coreContractPath = $this->projectDir . '/core-contract.json';

        if (!is_dir($customDir)) {
            $report->addError('overlay.directory.missing', 'Не найдена директория overlay: custom/');

            return $report;
        }

        $coreData = $this->readJsonFile($coreContractPath, $report);
        $manifestData = $this->readJsonFile($manifestPath, $report);

        $coreContract = $this->extractCoreContract($coreData, $report, $coreContractPath);
        $requiredContract = $this->extractRequiredContract($manifestData, $report, $manifestPath);
        if ($coreContract !== null && $requiredContract !== null) {
            $this->validateContractConstraint($coreContract, $requiredContract, $report, $manifestPath);
        }

        $manifestModules = $this->extractManifestModules($manifestData, $report, $manifestPath);

        $overlaySrcDir = $customDir . '/src';
        if (!is_dir($overlaySrcDir)) {
            $report->addError('overlay.src.missing', 'В overlay отсутствует директория custom/src', $this->relativePath($overlaySrcDir));

            return $report;
        }

        $overlayPhpFiles = $this->collectFiles($overlaySrcDir, 'php');
        if ($overlayPhpFiles === []) {
            $report->addWarning('overlay.src.empty', 'В custom/src нет PHP-файлов');
        }

        $moduleMap = $this->discoverModuleSlugs($overlayPhpFiles, $report);
        $this->validateModuleConsistency($manifestModules, $moduleMap, $report, $manifestPath);
        $this->checkDuplicateRoleKeys($overlayPhpFiles, $report);
        $this->checkDuplicateSettingsKeys($overlayPhpFiles, $report);
        $this->checkInternalImports($overlayPhpFiles, $report);
        $this->checkTableNames($customDir, $overlayPhpFiles, $manifestModules, array_keys($moduleMap), $report);

        return $report;
    }

    /**
     * @param array<string, mixed>|null $json
     */
    private function extractCoreContract(?array $json, DoctorReport $report, string $path): ?string
    {
        $value = $json['contract'] ?? null;
        if (!is_string($value) || !preg_match('/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)$/', $value)) {
            $report->addError(
                'core.contract.invalid',
                'core-contract.json должен содержать поле "contract" в формате X.Y.Z',
                $this->relativePath($path),
            );

            return null;
        }

        return $value;
    }

    /**
     * @param array<string, mixed>|null $json
     */
    private function extractRequiredContract(?array $json, DoctorReport $report, string $path): ?string
    {
        $value = $json['core_contract'] ?? null;
        if (!is_string($value) || trim($value) === '') {
            $report->addError(
                'manifest.core_contract.missing',
                'custom/manifest.json должен содержать непустое поле "core_contract"',
                $this->relativePath($path),
            );

            return null;
        }

        return trim($value);
    }

    private function validateContractConstraint(string $coreContract, string $requiredContract, DoctorReport $report, string $manifestPath): void
    {
        try {
            $isCompatible = Semver::satisfies($coreContract, $requiredContract);
        } catch (\UnexpectedValueException $exception) {
            $report->addError(
                'manifest.core_contract.semver',
                sprintf('Некорректное semver-ограничение core_contract: %s', $exception->getMessage()),
                $this->relativePath($manifestPath),
            );

            return;
        }

        if (!$isCompatible) {
            $report->addError(
                'manifest.core_contract.incompatible',
                sprintf('Overlay требует контракт "%s", а ядро имеет "%s"', $requiredContract, $coreContract),
                $this->relativePath($manifestPath),
            );
        }
    }

    /**
     * @param array<string, mixed>|null $json
     *
     * @return list<string>
     */
    private function extractManifestModules(?array $json, DoctorReport $report, string $path): array
    {
        $owner = $json['owner'] ?? null;
        if (!is_string($owner) || trim($owner) === '') {
            $report->addError('manifest.owner.missing', 'custom/manifest.json должен содержать непустое поле "owner"', $this->relativePath($path));
        }

        $modules = $json['modules'] ?? null;
        if (!is_array($modules)) {
            $report->addError('manifest.modules.invalid', 'custom/manifest.json должен содержать массив "modules"', $this->relativePath($path));

            return [];
        }

        $normalized = [];
        foreach ($modules as $item) {
            if (!is_string($item) || trim($item) === '') {
                $report->addError('manifest.modules.entry_invalid', 'Массив "modules" должен содержать непустые строки', $this->relativePath($path));
                continue;
            }

            $normalized[] = strtolower(trim($item));
        }

        if ($normalized === []) {
            $report->addError('manifest.modules.empty', 'В "modules" должен быть хотя бы один модуль', $this->relativePath($path));

            return [];
        }

        $counts = array_count_values($normalized);
        foreach ($counts as $module => $count) {
            if ($count > 1) {
                $report->addError(
                    'manifest.modules.duplicate',
                    sprintf('Модуль "%s" повторяется в manifest.json %d раз(а)', $module, $count),
                    $this->relativePath($path),
                );
            }
        }

        return array_values(array_unique($normalized));
    }

    /**
     * @param list<string> $overlayPhpFiles
     *
     * @return array<string, list<string>>
     */
    private function discoverModuleSlugs(array $overlayPhpFiles, DoctorReport $report): array
    {
        $moduleMap = [];

        foreach ($overlayPhpFiles as $file) {
            $content = $this->readFile($file);
            if ($content === null) {
                continue;
            }

            if (!preg_match('/\bconst\s+SLUG\s*=\s*[\'"]([^\'"]+)[\'"]/m', $content, $matches)) {
                continue;
            }

            $slug = strtolower(trim($matches[1]));
            if ($slug === '') {
                $report->addError('module.slug.empty', 'Найден пустой SLUG в модуле', $this->relativePath($file));
                continue;
            }

            $moduleMap[$slug] ??= [];
            $moduleMap[$slug][] = $file;
        }

        foreach ($moduleMap as $slug => $paths) {
            if (count($paths) > 1) {
                $report->addError(
                    'module.slug.duplicate',
                    sprintf('SLUG "%s" объявлен в нескольких файлах', $slug),
                    $this->relativePath($paths[0]),
                );
            }
        }

        return $moduleMap;
    }

    /**
     * @param list<string> $manifestModules
     * @param array<string, list<string>> $moduleMap
     */
    private function validateModuleConsistency(array $manifestModules, array $moduleMap, DoctorReport $report, string $manifestPath): void
    {
        foreach ($manifestModules as $module) {
            if (!isset($moduleMap[$module])) {
                $report->addError(
                    'module.missing_implementation',
                    sprintf('Модуль "%s" указан в manifest.json, но не найден класс с const SLUG="%s"', $module, $module),
                    $this->relativePath($manifestPath),
                );
            }
        }

        foreach (array_keys($moduleMap) as $moduleSlug) {
            if (!in_array($moduleSlug, $manifestModules, true)) {
                $report->addError(
                    'module.not_declared',
                    sprintf('Модуль "%s" найден в коде, но отсутствует в manifest.json', $moduleSlug),
                    $this->relativePath($moduleMap[$moduleSlug][0]),
                );
            }
        }
    }

    /**
     * @param list<string> $overlayPhpFiles
     */
    private function checkDuplicateRoleKeys(array $overlayPhpFiles, DoctorReport $report): void
    {
        $occurrences = [];

        foreach ($overlayPhpFiles as $file) {
            $content = $this->readFile($file);
            if ($content === null) {
                continue;
            }

            if (!preg_match_all('/new\s+CustomRole\s*\(\s*[\'"]([^\'"]+)[\'"]/m', $content, $matches)) {
                continue;
            }

            foreach ($matches[1] as $roleKey) {
                $occurrences[$roleKey] ??= [];
                $occurrences[$roleKey][] = $file;
            }
        }

        foreach ($occurrences as $roleKey => $files) {
            $uniqueFiles = array_values(array_unique($files));
            if (count($uniqueFiles) > 1) {
                $report->addError(
                    'roles.duplicate',
                    sprintf('Ключ роли "%s" объявлен в нескольких местах overlay', $roleKey),
                    $this->relativePath($uniqueFiles[0]),
                );
            }
        }
    }

    /**
     * @param list<string> $overlayPhpFiles
     */
    private function checkDuplicateSettingsKeys(array $overlayPhpFiles, DoctorReport $report): void
    {
        $occurrences = [];

        foreach ($overlayPhpFiles as $file) {
            $content = $this->readFile($file);
            if ($content === null) {
                continue;
            }

            $keys = [];
            if (preg_match_all('/new\s+SettingDefinition\s*\(\s*[\'"]([^\'"]+)[\'"]/m', $content, $positionalMatches)) {
                $keys = array_merge($keys, $positionalMatches[1]);
            }

            if (preg_match_all('/new\s+SettingDefinition\s*\((?:(?!\)\s*;).)*?key\s*:\s*[\'"]([^\'"]+)[\'"]/s', $content, $namedMatches)) {
                $keys = array_merge($keys, $namedMatches[1]);
            }

            foreach (array_unique($keys) as $key) {
                $occurrences[$key] ??= [];
                $occurrences[$key][] = $file;
            }
        }

        foreach ($occurrences as $key => $files) {
            $uniqueFiles = array_values(array_unique($files));
            if (count($uniqueFiles) > 1) {
                $report->addError(
                    'settings.duplicate',
                    sprintf('Ключ настройки "%s" объявлен в нескольких файлах overlay', $key),
                    $this->relativePath($uniqueFiles[0]),
                );
            }
        }
    }

    /**
     * @param list<string> $overlayPhpFiles
     */
    private function checkInternalImports(array $overlayPhpFiles, DoctorReport $report): void
    {
        $internalClasses = $this->collectInternalCoreSymbols();
        if ($internalClasses === []) {
            return;
        }

        foreach ($overlayPhpFiles as $file) {
            $content = $this->readFile($file);
            if ($content === null) {
                continue;
            }

            if (!preg_match_all('/^use\s+([^;]+);/m', $content, $matches)) {
                continue;
            }

            foreach ($matches[1] as $importsLine) {
                $imports = array_map('trim', explode(',', $importsLine));
                foreach ($imports as $import) {
                    if ($import === '' || str_starts_with($import, 'function ') || str_starts_with($import, 'const ')) {
                        continue;
                    }

                    $importClass = preg_replace('/\s+as\s+.+$/i', '', $import);
                    $importClass = ltrim((string) $importClass, '\\');

                    if (isset($internalClasses[$importClass])) {
                        $report->addError(
                            'imports.internal_forbidden',
                            sprintf('Overlay импортирует internal-класс ядра: %s', $importClass),
                            $this->relativePath($file),
                        );
                    }
                }
            }
        }
    }

    /**
     * @return array<string, true>
     */
    private function collectInternalCoreSymbols(): array
    {
        $result = [];
        $coreFiles = $this->collectFiles($this->projectDir . '/src', 'php');

        foreach ($coreFiles as $file) {
            $content = $this->readFile($file);
            if ($content === null || !str_contains($content, '@internal')) {
                continue;
            }

            if (!preg_match('/^namespace\s+([^;]+);/m', $content, $namespaceMatch)) {
                continue;
            }

            if (!preg_match('/^\s*(?:final\s+|abstract\s+)?(?:class|interface|trait|enum)\s+([A-Za-z_][A-Za-z0-9_]*)/m', $content, $typeMatch)) {
                continue;
            }

            $result[$namespaceMatch[1] . '\\' . $typeMatch[1]] = true;
        }

        return $result;
    }

    /**
     * @param list<string> $overlayPhpFiles
     * @param list<string> $manifestModules
     * @param list<string> $discoveredModules
     */
    private function checkTableNames(
        string $customDir,
        array $overlayPhpFiles,
        array $manifestModules,
        array $discoveredModules,
        DoctorReport $report,
    ): void {
        $allowedSlugs = $manifestModules !== [] ? $manifestModules : $discoveredModules;
        $allowedPrefixes = array_map(
            fn (string $slug): string => 'custom_' . $this->normalizeSlug($slug) . '_',
            $allowedSlugs,
        );

        $tableReferences = [];
        foreach ($overlayPhpFiles as $file) {
            $content = $this->readFile($file);
            if ($content === null) {
                continue;
            }

            if (preg_match_all('/Table\s*\(\s*name\s*:\s*[\'"]([a-zA-Z0-9_]+)[\'"]/m', $content, $tableMatches)) {
                foreach ($tableMatches[1] as $table) {
                    $this->addTableReference($tableReferences, $table, $file);
                }
            }
        }

        $migrationDir = $customDir . '/migrations';
        foreach ($this->collectFiles($migrationDir, 'php') as $migrationFile) {
            $content = $this->readFile($migrationFile);
            if ($content === null) {
                continue;
            }

            if (preg_match_all('/\b(?:CREATE\s+TABLE|ALTER\s+TABLE|DROP\s+TABLE(?:\s+IF\s+EXISTS)?|INSERT\s+INTO|UPDATE|DELETE\s+FROM)\s+`?([a-zA-Z0-9_]+)`?/i', $content, $sqlMatches)) {
                foreach ($sqlMatches[1] as $table) {
                    $this->addTableReference($tableReferences, strtolower($table), $migrationFile);
                }
            }
        }

        foreach ($tableReferences as $table => $pathsMap) {
            $paths = array_keys($pathsMap);
            if (!str_starts_with($table, 'custom_')) {
                $report->addError(
                    'tables.prefix.invalid',
                    sprintf('Таблица "%s" должна иметь префикс custom_', $table),
                    $this->relativePath($paths[0]),
                );
            }

            if ($allowedPrefixes !== [] && !$this->startsWithAny($table, $allowedPrefixes)) {
                $report->addError(
                    'tables.module_prefix.invalid',
                    sprintf('Таблица "%s" не соответствует модулям из manifest.json', $table),
                    $this->relativePath($paths[0]),
                );
            }

            if (count($paths) > 1) {
                $report->addWarning(
                    'tables.multiple_references',
                    sprintf('Таблица "%s" упоминается в нескольких файлах (%d)', $table, count($paths)),
                    $this->relativePath($paths[0]),
                );
            }
        }
    }

    /**
     * @param array<string, array<string, true>> $tableReferences
     */
    private function addTableReference(array &$tableReferences, string $tableName, string $path): void
    {
        $table = strtolower($tableName);
        if ($table === '') {
            return;
        }

        $tableReferences[$table] ??= [];
        $tableReferences[$table][$path] = true;
    }

    /**
     * @return list<string>
     */
    private function collectFiles(string $directory, string $extension): array
    {
        if (!is_dir($directory)) {
            return [];
        }

        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS),
        );

        foreach ($iterator as $fileInfo) {
            if (!$fileInfo instanceof \SplFileInfo || !$fileInfo->isFile()) {
                continue;
            }

            if (strtolower($fileInfo->getExtension()) !== strtolower($extension)) {
                continue;
            }

            $files[] = $fileInfo->getPathname();
        }

        sort($files);

        return $files;
    }

    /**
     * @return array<string, mixed>|null
     */
    private function readJsonFile(string $path, DoctorReport $report): ?array
    {
        if (!is_file($path)) {
            $report->addError('json.file.missing', sprintf('Файл не найден: %s', $this->relativePath($path)), $this->relativePath($path));

            return null;
        }

        try {
            /** @var mixed $decoded */
            $decoded = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            $report->addError(
                'json.file.invalid',
                sprintf('Некорректный JSON в %s: %s', $this->relativePath($path), $exception->getMessage()),
                $this->relativePath($path),
            );

            return null;
        }

        if (!is_array($decoded)) {
            $report->addError('json.file.not_object', sprintf('%s должен содержать JSON-объект', $this->relativePath($path)), $this->relativePath($path));

            return null;
        }

        return $decoded;
    }

    private function readFile(string $path): ?string
    {
        $content = file_get_contents($path);
        if ($content === false) {
            return null;
        }

        return $content;
    }

    private function relativePath(string $path): string
    {
        $prefix = rtrim($this->projectDir, '/') . '/';
        if (str_starts_with($path, $prefix)) {
            return substr($path, strlen($prefix));
        }

        return $path;
    }

    private function normalizeSlug(string $slug): string
    {
        $normalized = strtolower($slug);
        $normalized = preg_replace('/[^a-z0-9]+/', '_', $normalized);

        return trim((string) $normalized, '_');
    }

    /**
     * @param list<string> $prefixes
     */
    private function startsWithAny(string $value, array $prefixes): bool
    {
        foreach ($prefixes as $prefix) {
            if ($prefix !== '' && str_starts_with($value, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
