<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger\Sms;

use App\Application\Authorize\Gateway\SmsSenderInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Ставит отправку SMS в очередь Messenger (транспорт async, см. messenger.yaml),
 * чтобы Action не блокировался на HTTP-вызове SMS-шлюза.
 */
final class QueuedSmsSender implements SmsSenderInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {}

    public function send(string $phone, string $message): void
    {
        $this->messageBus->dispatch(new SendSmsMessage(phone: $phone, message: $message));
    }
}
