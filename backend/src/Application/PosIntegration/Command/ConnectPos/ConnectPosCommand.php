<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Command\ConnectPos;

class ConnectPosCommand
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $venueId,
        public readonly string $posSystem,
        public readonly string $apiLogin,
        public readonly string $organizationId,
        public readonly string $externalMenuId,
    ) {}
}
