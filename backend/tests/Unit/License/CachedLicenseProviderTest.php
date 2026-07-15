<?php

declare(strict_types=1);

namespace App\Tests\Unit\License;

use App\Application\License\Contract\ControlPlaneLicenseClientInterface;
use App\Application\License\Enum\LicenseStatusEnum;
use App\Application\License\ValueObject\LicenseSnapshot;
use App\Application\Tarif\Entity\Tarif\TarifCodeEnum;
use App\Infrastructure\License\CachedLicenseProvider;
use App\Shared\Enum\Feature\FeatureCodeEnum;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

final class CachedLicenseProviderTest extends TestCase
{
    public function testRefreshSavesSnapshotToCache(): void
    {
        $cache = new ArrayAdapter();
        $provider = new CachedLicenseProvider(
            client: new FixedLicenseClient($this->snapshotNow()),
            cache: $cache,
            cacheTtlSeconds: 300,
            graceTtlSeconds: 259200,
        );

        $snapshot = $provider->refresh();

        self::assertSame(TarifCodeEnum::PRO, $snapshot->tarifCode);
        self::assertSame([FeatureCodeEnum::CRM, FeatureCodeEnum::ANALYTICS], $snapshot->features);
    }

    public function testReturnsStaleCacheWithinGraceWhenControlPlaneIsUnavailable(): void
    {
        $cache = new ArrayAdapter();
        $item = $cache->getItem('license.snapshot.v1');
        $item->set([
            'tarif' => 'pro',
            'features' => ['crm'],
            'status' => 'active',
            'valid_until' => null,
            'fetched_at' => (new \DateTimeImmutable('-5 minutes'))->format(\DateTimeInterface::ATOM),
        ]);
        $cache->save($item);

        $provider = new CachedLicenseProvider(
            client: new FailingLicenseClient(),
            cache: $cache,
            cacheTtlSeconds: 60,
            graceTtlSeconds: 3600,
        );

        $snapshot = $provider->getSnapshot();

        self::assertSame(TarifCodeEnum::PRO, $snapshot->tarifCode);
        self::assertSame([FeatureCodeEnum::CRM], $snapshot->features);
    }

    public function testThrowsWhenCacheIsExpiredBeyondGraceAndControlPlaneFails(): void
    {
        $cache = new ArrayAdapter();
        $item = $cache->getItem('license.snapshot.v1');
        $item->set([
            'tarif' => 'pro',
            'features' => ['crm'],
            'status' => 'active',
            'valid_until' => null,
            'fetched_at' => (new \DateTimeImmutable('-4 days'))->format(\DateTimeInterface::ATOM),
        ]);
        $cache->save($item);

        $provider = new CachedLicenseProvider(
            client: new FailingLicenseClient(),
            cache: $cache,
            cacheTtlSeconds: 60,
            graceTtlSeconds: 3600,
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Лицензия устарела и недоступна в control-plane');

        $provider->getSnapshot();
    }

    private function snapshotNow(): LicenseSnapshot
    {
        return new LicenseSnapshot(
            tarifCode: TarifCodeEnum::PRO,
            features: [FeatureCodeEnum::CRM, FeatureCodeEnum::ANALYTICS],
            status: LicenseStatusEnum::Active,
            validUntil: null,
            fetchedAt: new \DateTimeImmutable(),
        );
    }
}

final class FixedLicenseClient implements ControlPlaneLicenseClientInterface
{
    public function __construct(private readonly LicenseSnapshot $snapshot) {}

    public function fetch(): LicenseSnapshot
    {
        return $this->snapshot;
    }
}

final class FailingLicenseClient implements ControlPlaneLicenseClientInterface
{
    public function fetch(): LicenseSnapshot
    {
        throw new \RuntimeException('control-plane down');
    }
}
