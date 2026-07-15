<?php

declare(strict_types=1);

namespace App\Infrastructure\License;

use App\Application\License\Contract\ControlPlaneLicenseClientInterface;
use App\Application\License\ValueObject\LicenseSnapshot;
use Delivery\Contracts\Enum\FeatureCodeEnum;
use Delivery\Contracts\Enum\LicenseStatusEnum;
use Delivery\Contracts\Enum\TarifCodeEnum;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ControlPlaneLicenseClient implements ControlPlaneLicenseClientInterface
{
    private const LICENSE_PATH = '/v1/license';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $controlPlaneUrl,
        private readonly string $serverToken,
    ) {}

    public function fetch(): LicenseSnapshot
    {
        if ($this->controlPlaneUrl === '') {
            throw new \RuntimeException('Не задан CONTROL_PLANE_URL');
        }

        if ($this->serverToken === '') {
            throw new \RuntimeException('Не задан SERVER_TOKEN');
        }

        try {
            $response = $this->httpClient->request(
                'GET',
                rtrim($this->controlPlaneUrl, '/') . self::LICENSE_PATH,
                [
                    'query' => [
                        'server_token' => $this->serverToken,
                    ],
                ],
            );
            $payload = $response->toArray();
        } catch (\Throwable) {
            throw new \RuntimeException('Не удалось получить лицензию из control-plane');
        }

        return $this->snapshotFromPayload($payload);
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function snapshotFromPayload(array $payload): LicenseSnapshot
    {
        $tarifRaw = $payload['tarif'] ?? null;
        $statusRaw = $payload['status'] ?? null;
        $featuresRaw = $payload['features'] ?? null;
        $validUntilRaw = $payload['valid_until'] ?? null;

        if (!is_string($tarifRaw) || !is_string($statusRaw) || !is_array($featuresRaw)) {
            throw new \RuntimeException('Control-plane вернул невалидный контракт лицензии');
        }

        try {
            $tarifCode = TarifCodeEnum::from($tarifRaw);
            $status = LicenseStatusEnum::from($statusRaw);
        } catch (\ValueError) {
            throw new \RuntimeException('Control-plane вернул неизвестный тариф или статус лицензии');
        }

        $features = [];
        foreach ($featuresRaw as $featureRaw) {
            if (!is_string($featureRaw)) {
                continue;
            }

            try {
                $features[] = FeatureCodeEnum::from($featureRaw);
            } catch (\ValueError) {
                // Неизвестные фичи игнорируются для обратной совместимости.
            }
        }

        $validUntil = null;
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
            fetchedAt: new \DateTimeImmutable(),
        );
    }
}

