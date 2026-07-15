<?php

declare(strict_types=1);

namespace App\Infrastructure\ControlPlane;

use App\Application\Heartbeat\Contract\HeartbeatClientInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ControlPlaneHeartbeatClient implements HeartbeatClientInterface
{
    private const HEARTBEAT_PATH = '/v1/heartbeat';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $controlPlaneUrl,
        private readonly string $serverToken,
    ) {}

    public function send(string $coreRef, string $contractVersion, string $healthStatus = 'ok'): void
    {
        if ($this->controlPlaneUrl === '' || $this->serverToken === '') {
            throw new \RuntimeException('Не заданы параметры подключения к control-plane для heartbeat');
        }

        try {
            $this->httpClient->request(
                'POST',
                rtrim($this->controlPlaneUrl, '/') . self::HEARTBEAT_PATH,
                [
                    'json' => [
                        'server_token' => $this->serverToken,
                        'core_ref' => $coreRef,
                        'contract_version' => $contractVersion,
                        'health_status' => $healthStatus,
                    ],
                ],
            )->toArray();
        } catch (\Throwable) {
            throw new \RuntimeException('Не удалось отправить heartbeat в control-plane');
        }
    }
}

