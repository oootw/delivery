<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger\Sms;

final class SendSmsMessage
{
    public function __construct(
        public readonly string $phone,
        public readonly string $message,
    ) {}
}
