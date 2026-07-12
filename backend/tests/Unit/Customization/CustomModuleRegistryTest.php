<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customization;

use App\Application\Customization\Contract\AbstractCustomModule;
use App\Application\Customization\Contract\CustomModuleInterface;
use App\Application\Customization\Entity\WorkspaceCustomModule\WorkspaceCustomModule;
use App\Application\Customization\Entity\WorkspaceCustomModule\WorkspaceCustomModuleRepositoryInterface;
use App\Application\Customization\Registry\CustomModuleRegistry;
use PHPUnit\Framework\TestCase;

final class CustomModuleRegistryTest extends TestCase
{
    public function testAllIndexesModulesBySlug(): void
    {
        $registry = $this->registry([$this->module('acme'), $this->module('globex')], []);

        self::assertSame(['acme', 'globex'], array_keys($registry->all()));
        self::assertTrue($registry->has('acme'));
        self::assertNull($registry->get('missing'));
    }

    public function testDuplicateSlugThrows(): void
    {
        $registry = $this->registry([$this->module('acme'), $this->module('acme')], []);

        $this->expectException(\LogicException::class);
        $registry->all();
    }

    public function testActiveForReturnsOnlyEnabledRegisteredModules(): void
    {
        // Включены acme и ghost, но код есть только у acme → ghost игнорируется.
        $registry = $this->registry(
            [$this->module('acme'), $this->module('globex')],
            [7 => ['acme', 'ghost']],
        );

        $active = $registry->activeFor(7);

        self::assertCount(1, $active);
        self::assertSame('acme', $active[0]->slug());
        self::assertTrue($registry->isActive(7, 'acme'));
        self::assertFalse($registry->isActive(7, 'globex')); // код есть, но не включён
        self::assertFalse($registry->isActive(7, 'ghost'));  // включён, но кода нет
    }

    public function testInactiveWorkspaceHasNoModules(): void
    {
        $registry = $this->registry([$this->module('acme')], []);

        self::assertSame([], $registry->activeFor(99));
    }

    public function testActivationSurvivesSlugRenameViaPreviousSlugs(): void
    {
        // Модуль переименован acme → acme_v2, но активация хранит старый slug.
        $renamed = $this->module('acme_v2', previousSlugs: ['acme']);
        $registry = $this->registry([$renamed], [7 => ['acme']]);

        $active = $registry->activeFor(7);

        self::assertCount(1, $active);
        self::assertSame('acme_v2', $active[0]->slug());
        self::assertTrue($registry->isActive(7, 'acme_v2')); // по текущему slug
        self::assertTrue($registry->isActive(7, 'acme'));    // по прежнему slug
    }

    public function testConflictingEffectiveSlugThrows(): void
    {
        // Два модуля претендуют на один эффективный slug (через алиас) — ошибка конфигурации.
        $registry = $this->registry(
            [$this->module('acme'), $this->module('globex', previousSlugs: ['acme'])],
            [],
        );

        $this->expectException(\LogicException::class);
        $registry->all();
    }

    /**
     * @param list<CustomModuleInterface> $modules
     * @param array<int, list<string>>    $enabledByWorkspace
     */
    private function registry(array $modules, array $enabledByWorkspace): CustomModuleRegistry
    {
        return new CustomModuleRegistry($modules, $this->activationRepo($enabledByWorkspace));
    }

    /**
     * @param list<string> $previousSlugs
     */
    private function module(string $slug, array $previousSlugs = []): CustomModuleInterface
    {
        return new class($slug, $previousSlugs) extends AbstractCustomModule {
            /** @param list<string> $previousSlugs */
            public function __construct(
                private readonly string $slug,
                private readonly array $previousSlugs,
            ) {}

            public function slug(): string
            {
                return $this->slug;
            }

            public function title(): string
            {
                return ucfirst($this->slug);
            }

            public function previousSlugs(): array
            {
                return $this->previousSlugs;
            }
        };
    }

    /**
     * @param array<int, list<string>> $enabledByWorkspace
     */
    private function activationRepo(array $enabledByWorkspace): WorkspaceCustomModuleRepositoryInterface
    {
        return new class($enabledByWorkspace) implements WorkspaceCustomModuleRepositoryInterface {
            /** @param array<int, list<string>> $enabledByWorkspace */
            public function __construct(private readonly array $enabledByWorkspace) {}

            public function save(WorkspaceCustomModule $module): int
            {
                return $module->id ?? 0;
            }

            public function findByWorkspaceAndSlug(int $workspaceId, string $slug): ?WorkspaceCustomModule
            {
                return null;
            }

            public function findByWorkspace(int $workspaceId): array
            {
                return [];
            }

            public function findEnabledSlugsByWorkspace(int $workspaceId): array
            {
                return $this->enabledByWorkspace[$workspaceId] ?? [];
            }
        };
    }
}
