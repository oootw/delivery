<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CheckOntimeCode;

class Command
{
    public function __construct(
        public readonly string $phone,
        public readonly string $code,
        public readonly string $codeType,
    ) {}
}
