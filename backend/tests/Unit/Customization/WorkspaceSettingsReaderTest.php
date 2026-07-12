<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customization;

use App\Application\Customization\Entity\WorkspaceSettings\WorkspaceSettings;
use App\Application\Customization\Entity\WorkspaceSettings\WorkspaceSettingsRepositoryInterface;
use App\Application\Customization\Settings\SettingDefinition;
use App\Application\Customization\Settings\SettingsCatalog;
use App\Application\Customization\Settings\SettingsProviderInterface;
use App\Application\Customization\Settings\SettingType;
use App\Application\Customization\Settings\WorkspaceSettingsReader;
use PHPUnit\Framework\TestCase;

final class WorkspaceSettingsReaderTest extends TestCase
{
    public function testFallsBackToDefaultWhenNotStored(): void
    {
        $reader = $this->reader(
            [$this->def('orders.auto_accept', SettingType::Bool, false)],
            stored: [],
        );

        self::assertFalse($reader->bool(7, 'orders.auto_accept'));
    }

    public function testReturnsStoredValueOverDefault(): void
    {
        $reader = $this->reader(
            [$this->def('orders.auto_accept', SettingType::Bool, false)],
            stored: [7 => ['orders.auto_accept' => true]],
        );

        self::assertTrue($reader->bool(7, 'orders.auto_accept'));
    }

    public function testTypedHelpersReturnDeclaredTypes(): void
    {
        $reader = $this->reader(
            [
                $this->def('limit', SettingType::Int, 5),
                $this->def('label', SettingType::Str, 'default'),
            ],
            stored: [7 => ['limit' => 20]],
        );

        self::assertSame(20, $reader->int(7, 'limit'));
        self::assertSame('default', $reader->string(7, 'label')); // не сохранено → дефолт
    }

    public function testUnknownKeyThrows(): void
    {
        $reader = $this->reader([$this->def('known', SettingType::Bool, false)], stored: []);

        $this->expectException(\DomainException::class);
        $reader->get(7, 'unknown');
    }

    public function testTypeMismatchHelperThrows(): void
    {
        $reader = $this->reader([$this->def('limit', SettingType::Int, 0)], stored: []);

        $this->expectException(\DomainException::class);
        $reader->bool(7, 'limit'); // объявлен Int, запрошен bool
    }

    private function def(string $key, SettingType $type, bool|int|string $default): SettingDefinition
    {
        return new SettingDefinition($key, $type, $default, ucfirst($key));
    }

    /**
     * @param list<SettingDefinition>                       $defs
     * @param array<int, array<string, bool|int|string>>    $stored
     */
    private function reader(array $defs, array $stored): WorkspaceSettingsReader
    {
        $catalog = new SettingsCatalog([
            new class($defs) implements SettingsProviderInterface {
                /** @param list<SettingDefinition> $defs */
                public function __construct(private readonly array $defs) {}

                public function definitions(): array
                {
                    return $this->defs;
                }
            },
        ]);

        $repository = new class($stored) implements WorkspaceSettingsRepositoryInterface {
            /** @param array<int, array<string, bool|int|string>> $stored */
            public function __construct(private readonly array $stored) {}

            public function save(WorkspaceSettings $settings): int
            {
                return 0;
            }

            public function findByWorkspace(int $workspaceId): ?WorkspaceSettings
            {
                if (!isset($this->stored[$workspaceId])) {
                    return null;
                }

                $now = new \DateTimeImmutable();

                return new WorkspaceSettings(
                    id: $workspaceId,
                    workspaceId: $workspaceId,
                    values: $this->stored[$workspaceId],
                    createdAt: $now,
                    updatedAt: $now,
                );
            }

            public function getOrCreate(int $workspaceId): WorkspaceSettings
            {
                return $this->findByWorkspace($workspaceId) ?? WorkspaceSettings::buildNew($workspaceId);
            }
        };

        return new WorkspaceSettingsReader($catalog, $repository);
    }
}
