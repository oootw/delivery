<?php

declare(strict_types=1);

namespace App\Tests\Unit\License;

use App\Application\License\Enum\LicenseStatusEnum;
use App\Application\License\Service\TarifFeatureCatalog;
use App\Infrastructure\License\InMemoryServerLicenseRegistry;
use App\Shared\Enum\Feature\FeatureCodeEnum;
use PHPUnit\Framework\TestCase;

final class InMemoryServerLicenseRegistryTest extends TestCase
{
    public function testFindsRecordByToken(): void
    {
        $registry = new InMemoryServerLicenseRegistry(
            registryJson: '[{"server_token":"token-1","owner_id":10,"workspace_id":20,"tarif":"pro","status":"active","valid_until":"2030-01-01T00:00:00+00:00","features":["crm","analytics"]}]',
            tarifFeatureCatalog: new TarifFeatureCatalog(),
        );

        $record = $registry->findByToken('token-1');

        self::assertNotNull($record);
        self::assertSame(10, $record->ownerId);
        self::assertSame(20, $record->workspaceId);
        self::assertSame(LicenseStatusEnum::Active, $record->status);
        self::assertSame([FeatureCodeEnum::CRM, FeatureCodeEnum::ANALYTICS], $record->features);
    }

    public function testFallsBackToTarifCatalogWhenFeaturesAreMissing(): void
    {
        $registry = new InMemoryServerLicenseRegistry(
            registryJson: '[{"server_token":"token-2","owner_id":1,"workspace_id":1,"tarif":"basic","status":"active"}]',
            tarifFeatureCatalog: new TarifFeatureCatalog(),
        );

        $record = $registry->findByToken('token-2');

        self::assertNotNull($record);
        self::assertSame([FeatureCodeEnum::POINTS], $record->features);
    }

    public function testThrowsForInvalidRegistryJson(): void
    {
        $registry = new InMemoryServerLicenseRegistry(
            registryJson: '{broken',
            tarifFeatureCatalog: new TarifFeatureCatalog(),
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('LICENSE_SERVER_REGISTRY содержит невалидный JSON');

        $registry->findByToken('any-token');
    }
}
