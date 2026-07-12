<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Command\RequestMenuImport;

class RequestMenuImportCommand
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $venueId,
    ) {}
}
