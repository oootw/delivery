<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\GetSmsCode;

class Query
{
    public function __construct(
        public string $phone,
        public string $message,
    ) {}
}
