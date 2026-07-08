<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Command\ImportMenu;

class Command
{
    public function __construct(
        public readonly int $posConnectionId,
    ) {}
}
