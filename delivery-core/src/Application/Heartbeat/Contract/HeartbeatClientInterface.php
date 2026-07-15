<?php

declare(strict_types=1);

namespace App\Application\Heartbeat\Contract;

interface HeartbeatClientInterface
{
    public function send(string $coreRef, string $contractVersion, string $healthStatus = 'ok'): void;
}

