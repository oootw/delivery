<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customization;

use App\Application\Customization\Settings\SettingDefinition;
use App\Application\Customization\Settings\SettingsCatalog;
use App\Application\Customization\Settings\SettingsProviderInterface;
use App\Application\Customization\Settings\SettingType;
use PHPUnit\Framework\TestCase;

final class SettingsCatalogTest extends TestCase
{
    public function testCollectsDefinitionsFromProviders(): void
    {
        $catalog = $this->catalog(
            [$this->def('a.flag', SettingType::Bool, false)],
            [$this->def('b.limit', SettingType::Int, 10)],
        );

        self::assertSame(['a.flag', 'b.limit'], array_keys($catalog->all()));
        self::assertTrue($catalog->has('a.flag'));
        self::assertNull($catalog->get('missing'));
    }

    public function testDuplicateKeyAcrossProvidersThrows(): void
    {
        $catalog = $this->catalog(
            [$this->def('dup', SettingType::Bool, false)],
            [$this->def('dup', SettingType::Int, 1)],
        );

        $this->expectException(\LogicException::class);
        $catalog->all();
    }

    public function testCoerceValidatesAndCastsByType(): void
    {
        $catalog = $this->catalog([
            $this->def('flag', SettingType::Bool, false),
            $this->def('limit', SettingType::Int, 0),
            $this->def('label', SettingType::Str, ''),
        ]);

        self::assertSame(
            ['flag' => true, 'limit' => 42, 'label' => 'hi'],
            $catalog->coerce(['flag' => true, 'limit' => 42, 'label' => 'hi']),
        );
        // Bool терпит 0/1
        self::assertSame(['flag' => true], $catalog->coerce(['flag' => 1]));
    }

    public function testCoerceRejectsUnknownKey(): void
    {
        $catalog = $this->catalog([$this->def('flag', SettingType::Bool, false)]);

        $this->expectException(\DomainException::class);
        $catalog->coerce(['nope' => true]);
    }

    public function testCoerceRejectsWrongType(): void
    {
        $catalog = $this->catalog([$this->def('limit', SettingType::Int, 0)]);

        $this->expectException(\DomainException::class);
        $catalog->coerce(['limit' => 'not-int']);
    }

    public function testIntRejectsBool(): void
    {
        $catalog = $this->catalog([$this->def('limit', SettingType::Int, 0)]);

        $this->expectException(\DomainException::class);
        $catalog->coerce(['limit' => true]);
    }

    private function def(string $key, SettingType $type, bool|int|string $default): SettingDefinition
    {
        return new SettingDefinition($key, $type, $default, ucfirst($key));
    }

    private function catalog(array ...$providerDefs): SettingsCatalog
    {
        $providers = array_map(
            static fn(array $defs): SettingsProviderInterface => new class($defs) implements SettingsProviderInterface {
                /** @param list<SettingDefinition> $defs */
                public function __construct(private readonly array $defs) {}

                public function definitions(): array
                {
                    return $this->defs;
                }
            },
            $providerDefs,
        );

        return new SettingsCatalog($providers);
    }
}
