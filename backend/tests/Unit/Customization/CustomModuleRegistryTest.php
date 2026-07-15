<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customization;

use App\Application\Customization\Contract\AbstractCustomModule;
use App\Application\Customization\Contract\CustomModuleInterface;
use App\Application\Customization\Registry\CustomModuleRegistry;
use PHPUnit\Framework\TestCase;

final class CustomModuleRegistryTest extends TestCase
{
    public function testAllIndexesModulesBySlug(): void
    {
        $registry = $this->registry([$this->module('acme'), $this->module('globex')]);

        self::assertSame(['acme', 'globex'], array_keys($registry->all()));
        self::assertTrue($registry->has('acme'));
        self::assertNull($registry->get('missing'));
    }

    public function testDuplicateSlugThrows(): void
    {
        $registry = $this->registry([$this->module('acme'), $this->module('acme')]);

        $this->expectException(\LogicException::class);
        $registry->all();
    }

    public function testAllModulesAreActiveInSingleTenantMode(): void
    {
        $registry = $this->registry([$this->module('acme'), $this->module('globex')]);

        self::assertTrue($registry->has('acme'));
        self::assertTrue($registry->has('globex'));
    }

    /**
     * @param list<CustomModuleInterface> $modules
     */
    private function registry(array $modules): CustomModuleRegistry
    {
        return new CustomModuleRegistry($modules);
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

}
