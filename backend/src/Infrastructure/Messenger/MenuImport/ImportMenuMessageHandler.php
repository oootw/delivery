<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger\MenuImport;

use App\Application\PosIntegration\Command\ImportMenu\ImportMenuCommand;
use App\Application\PosIntegration\Command\ImportMenu\ImportMenuHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ImportMenuMessageHandler
{
    public function __construct(
        private readonly ImportMenuHandler $importMenu,
    ) {}

    public function __invoke(ImportMenuMessage $message): void
    {
        $this->importMenu->handle(
            new ImportMenuCommand(posConnectionId: $message->posConnectionId),
        );
    }
}
