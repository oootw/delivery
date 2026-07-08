<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger\MenuImport;

final class ImportMenuMessage
{
    public function __construct(
        public readonly int $posConnectionId,
    ) {}
}
