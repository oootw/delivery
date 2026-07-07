<?php

declare(strict_types=1);

namespace App\Application\Users\Command\SetSubscribeOnTarif;

class Command
{
    public function __construct(
        public readonly int $userId,
        public readonly string $tarifCode,
    ) {}
}
