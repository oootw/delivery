<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Gateway;

/**
 * Порт постановки импорта меню в фоновую обработку.
 * Реализация ставит сообщение в очередь Messenger (транспорт async).
 */
interface MenuImportQueueInterface
{
    public function enqueue(int $posConnectionId): void;
}
