<?php

declare(strict_types=1);

namespace App\Infrastructure\License;

use App\Application\License\Enum\LicenseStatusEnum;
use App\Application\License\Registry\ServerLicenseRegistryInterface;
use App\Application\License\Service\TarifFeatureCatalog;
use App\Application\License\ValueObject\ServerLicenseRecord;
use App\Application\Tarif\Entity\Tarif\TarifCodeEnum;
use App\Shared\Enum\Feature\FeatureCodeEnum;

final class InMemoryServerLicenseRegistry implements ServerLicenseRegistryInterface
{
    /** @var array<string, ServerLicenseRecord>|null */
    private ?array $recordsByToken = null;

    public function __construct(
        private readonly string $registryJson,
        private readonly TarifFeatureCatalog $tarifFeatureCatalog,
    ) {}

    public function findByToken(string $serverToken): ?ServerLicenseRecord
    {
        if ($serverToken === '') {
            return null;
        }

        return $this->records()[$serverToken] ?? null;
    }

    /**
     * @return array<string, ServerLicenseRecord>
     */
    private function records(): array
    {
        if ($this->recordsByToken !== null) {
            return $this->recordsByToken;
        }

        if ($this->registryJson === '') {
            $this->recordsByToken = [];

            return $this->recordsByToken;
        }

        try {
            /** @var mixed $decoded */
            $decoded = json_decode($this->registryJson, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new \RuntimeException('LICENSE_SERVER_REGISTRY содержит невалидный JSON');
        }

        if (!is_array($decoded)) {
            throw new \RuntimeException('LICENSE_SERVER_REGISTRY должен быть массивом');
        }

        $recordsByToken = [];

        foreach ($decoded as $item) {
            if (!is_array($item)) {
                continue;
            }

            $token = isset($item['server_token']) ? trim((string) $item['server_token']) : '';
            if ($token === '') {
                continue;
            }

            $ownerId = (int) ($item['owner_id'] ?? 0);
            $workspaceId = (int) ($item['workspace_id'] ?? 0);

            if ($ownerId <= 0 || $workspaceId <= 0) {
                continue;
            }

            $tarifRaw = isset($item['tarif']) ? (string) $item['tarif'] : '';
            $statusRaw = isset($item['status']) ? (string) $item['status'] : '';

            try {
                $tarifCode = TarifCodeEnum::from($tarifRaw);
                $status = LicenseStatusEnum::from($statusRaw);
            } catch (\ValueError) {
                continue;
            }

            $validUntil = null;
            if (isset($item['valid_until']) && is_string($item['valid_until']) && $item['valid_until'] !== '') {
                try {
                    $validUntil = new \DateTimeImmutable($item['valid_until']);
                } catch (\Throwable) {
                    $validUntil = null;
                }
            }

            $features = $this->featuresFromPayload($item['features'] ?? null, $tarifCode);

            $recordsByToken[$token] = new ServerLicenseRecord(
                ownerId: $ownerId,
                workspaceId: $workspaceId,
                tarifCode: $tarifCode,
                features: $features,
                status: $status,
                validUntil: $validUntil,
            );
        }

        $this->recordsByToken = $recordsByToken;

        return $this->recordsByToken;
    }

    /**
     * @return list<FeatureCodeEnum>
     */
    private function featuresFromPayload(mixed $featuresRaw, TarifCodeEnum $tarifCode): array
    {
        if (!is_array($featuresRaw)) {
            return $this->tarifFeatureCatalog->byTarifCode($tarifCode);
        }

        $features = [];

        foreach ($featuresRaw as $featureRaw) {
            if (!is_string($featureRaw)) {
                continue;
            }

            try {
                $features[] = FeatureCodeEnum::from($featureRaw);
            } catch (\ValueError) {
                // Пропускаем неизвестную фичу из конфига.
            }
        }

        if ($features === []) {
            return $this->tarifFeatureCatalog->byTarifCode($tarifCode);
        }

        return array_values(array_unique($features, \SORT_REGULAR));
    }
}
