<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\GetSmsDailyLimitAvailable;

class GetSmsDailyLimitAvailableQuery
{
    public function __construct(
        public string $phone,
    ) {}
}
