<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\GetSmsCode;

use App\Application\Authorize\Gateway\SmsSenderInterface;

class GetSmsCodeFetcher
{
    public function __construct(
        private readonly SmsSenderInterface $smsSender,
    ) {}

    public function fetch(GetSmsCodeQuery $query): void
    {
        $this->smsSender->send(
            phone: $query->phone,
            message: $query->message,
        );
    }
}
