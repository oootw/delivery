<?php

declare(strict_types=1);

namespace App\Application\Authorize\Gateway;

/**
 * Порт отправки SMS. Адаптер ставит сообщение в очередь (Messenger async),
 * чтобы HTTP-запрос не блокировался на SMS-шлюзе.
 */
interface SmsSenderInterface
{
    public function send(string $phone, string $message): void;
}
