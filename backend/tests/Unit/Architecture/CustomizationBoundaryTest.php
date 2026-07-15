<?php

declare(strict_types=1);

namespace App\Tests\Unit\Architecture;

use PHPUnit\Framework\TestCase;

/**
 * Guardrail главного инварианта системы кастомизации: ядро не знает про клиентский кастом.
 *
 * Слои App\Application / App\Infrastructure / App\Http НЕ имеют права ссылаться на
 * App\Custom\*. Кастом подключается через overlay и теги контейнера, а не по имени
 * класса в ядре. Нарушение = красный тест (см. backend/PLAN_CUSTOMIZATION.md).
 */
final class CustomizationBoundaryTest extends TestCase
{
    private const CORE_DIRS = ['Application', 'Infrastructure', 'Http'];

    public function testCoreDoesNotReferenceCustomNamespace(): void
    {
        $srcDir = \dirname(__DIR__, 3) . '/src';
        $offenders = [];

        foreach (self::CORE_DIRS as $dir) {
            foreach ($this->phpFiles($srcDir . '/' . $dir) as $file) {
                $contents = file_get_contents($file);

                if ($contents !== false && preg_match('/\bApp\\\\Custom\\\\/', $contents) === 1) {
                    $offenders[] = substr($file, \strlen($srcDir) + 1);
                }
            }
        }

        self::assertSame(
            [],
            $offenders,
            "Ядро ссылается на App\\Custom (запрещено):\n" . implode("\n", $offenders),
        );
    }

    /**
     * @return iterable<string>
     */
    private function phpFiles(string $dir): iterable
    {
        if (!is_dir($dir)) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                yield $file->getPathname();
            }
        }
    }
}
