<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger\Sms;

use App\Shared\Service\SMSManager\SMSManager;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SendSmsMessageHandler
{
    public function __construct(
        private readonly SMSManager $smsManager,
    ) {}

    public function __invoke(SendSmsMessage $message): void
    {
        $this->smsManager->sendSMS(
            phone: $message->phone,
            message: $message->message,
        );
    }
}
