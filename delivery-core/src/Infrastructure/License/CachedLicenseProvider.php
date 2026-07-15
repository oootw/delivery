<?php

declare(strict_types=1);

namespace App\Infrastructure\License;

use App\Application\License\Contract\ControlPlaneLicenseClientInterface;
use App\Application\License\Contract\LicenseProviderInterface;
use App\Application\License\ValueObject\LicenseSnapshot;
use Delivery\Contracts\Enum\FeatureCodeEnum;
use Delivery\Contracts\Enum\LicenseStatusEnum;
use Delivery\Contracts\Enum\TarifCodeEnum;
use Psr\Cache\CacheItemPoolInterface;

final class CachedLicenseProvider implements LicenseProviderInterface
{
    private const CACHE_KEY = 'license.snapshot.v1';

    public function __construct(
        private readonly ControlPlaneLicenseClientInterface $client,
        private readonly CacheItemPoolInterface $cache,
        private readonly int $cacheTtlSeconds = 300,
        private readonly int $graceTtlSeconds = 259200,
    ) {}

    public function getSnapshot(): LicenseSnapshot
    {
        $cached = $this->readCached();
        if ($cached === null) {
            return $this->refresh();
        }

        $ageSeconds = time() - $cached->fetchedAt->getTimestamp();
        if ($ageSeconds <= $this->cacheTtlSeconds) {
            return $cached;
        }

        try {
            return $this->refresh();
        } catch (\Throwable) {
            if ($ageSeconds <= $this->graceTtlSeconds) {
                return $cached;
            }

            throw new \RuntimeException('Лицензия устарела и недоступна в control-plane');
        }
    }

    public function refresh(): LicenseSnapshot
    {
        $snapshot = $this->client->fetch();

        $cacheItem = $this->cache->getItem(self::CACHE_KEY);
        $cacheItem->set($this->encode($snapshot));
        $cacheItem->expiresAfter($this->graceTtlSeconds);
        $this->cache->save($cacheItem);

        return $snapshot;
    }

    private function readCached(): ?LicenseSnapshot
    {
        $cacheItem = $this->cache->getItem(self::CACHE_KEY);
        if (!$cacheItem->isHit()) {
            return null;
        }

        $payload = $cacheItem->get();
        if (!is_array($payload)) {
            return null;
        }

        return $this->decode($payload);
    }

    /**
     * @return array{
     *   tarif: string,
     *   features: list<string>,
     *   status: string,
     *   valid_until: string|null,
     *   fetched_at: string
     * }
     */
    private function encode(LicenseSnapshot $snapshot): array
    {
        return [
            'tarif' => $snapshot->tarifCode->value,
            'features' => array_map(
                static fn (FeatureCodeEnum $feature): string => $feature->value,
                $snapshot->features,
            ),
            'status' => $snapshot->status->value,
            'valid_until' => $snapshot->validUntil?->format(\DateTimeInterface::ATOM),
            'fetched_at' => $snapshot->fetchedAt->format(\DateTimeInterface::ATOM),
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function decode(array $payload): ?LicenseSnapshot
    {
        $tarifRaw = $payload['tarif'] ?? null;
        $featuresRaw = $payload['features'] ?? null;
        $statusRaw = $payload['status'] ?? null;
        $fetchedAtRaw = $payload['fetched_at'] ?? null;

        if (!is_string($tarifRaw) || !is_string($statusRaw) || !is_string($fetchedAtRaw) || !is_array($featuresRaw)) {
            return null;
        }

        try {
            $tarifCode = TarifCodeEnum::from($tarifRaw);
            $status = LicenseStatusEnum::from($statusRaw);
            $fetchedAt = new \DateTimeImmutable($fetchedAtRaw);
        } catch (\Throwable) {
            return null;
        }

        $features = [];
        foreach ($featuresRaw as $featureRaw) {
            if (!is_string($featureRaw)) {
                continue;
            }

            try {
                $features[] = FeatureCodeEnum::from($featureRaw);
            } catch (\ValueError) {
                // Невалидные фичи в кэше пропускаются.
            }
        }

        $validUntil = null;
        $validUntilRaw = $payload['valid_until'] ?? null;
        if (is_string($validUntilRaw) && $validUntilRaw !== '') {
            try {
                $validUntil = new \DateTimeImmutable($validUntilRaw);
            } catch (\Throwable) {
                $validUntil = null;
            }
        }

        return new LicenseSnapshot(
            tarifCode: $tarifCode,
            features: array_values(array_unique($features, \SORT_REGULAR)),
            status: $status,
            validUntil: $validUntil,
            fetchedAt: $fetchedAt,
        );
    }
}

