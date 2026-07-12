<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Command\ImportMenu;

use App\Application\Menu\Service\MenuImporter;
use App\Application\PosIntegration\Entity\PosConnection\PosConnectionRepositoryInterface;
use App\Application\PosIntegration\Gateway\PosMenuProviderRegistry;

/**
 * Оркестрация фонового импорта меню: тянет снимок из POS через провайдера,
 * приводит меню точки к нему и обновляет статус соединения.
 * Вызывается из Messenger-обработчика.
 */
class ImportMenuHandler
{
    public function __construct(
        private readonly PosConnectionRepositoryInterface $posConnections,
        private readonly PosMenuProviderRegistry $providers,
        private readonly MenuImporter $menuImporter,
    ) {}

    public function handle(ImportMenuCommand $command): void
    {
        $connection = $this->posConnections->findById($command->posConnectionId);

        if ($connection === null) {
            throw new \DomainException('POS-соединение не найдено');
        }

        try {
            $snapshot = $this->providers
                ->providerFor($connection->posSystem)
                ->fetchMenu($connection);

            $this->menuImporter->import($connection->venueId, $snapshot);

            $connection->markSynced();
            $this->posConnections->save($connection);
        } catch (\Throwable $exception) {
            $connection->markFailed($exception->getMessage());
            $this->posConnections->save($connection);

            throw $exception;
        }
    }
}
