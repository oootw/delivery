<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\GetSmsCodeSendAvailable;

class GetSmsCodeSendAvailableQuery
{
    public function __construct(
        public string $phone
    ) {}
}
