<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger\MenuImport;

use App\Application\PosIntegration\Gateway\MenuImportQueueInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Ставит импорт меню в очередь Messenger (транспорт async, см. messenger.yaml).
 */
final class MenuImportQueue implements MenuImportQueueInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {}

    public function enqueue(int $posConnectionId): void
    {
        $this->messageBus->dispatch(new ImportMenuMessage($posConnectionId));
    }
}
