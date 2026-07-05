<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\GetSmsCode;

use App\Shared\Service\SMSManager\SMSManager;

class Fetcher
{
    public function __construct(
        private readonly SMSManager $smsManager,
    ) {}

    public function fetch(Query $query): void
    {
        $this->smsManager->sendSMS(
            phone: $query->phone,
            message: $query->message,
        );
    }
}
