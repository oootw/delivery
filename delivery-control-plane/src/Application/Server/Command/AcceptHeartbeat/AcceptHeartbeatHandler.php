<?php

declare(strict_types=1);

namespace App\Application\Server\Command\AcceptHeartbeat;

use App\Application\Server\Entity\RegisteredServer\RegisteredServerRepositoryInterface;

final class AcceptHeartbeatHandler
{
    public function __construct(
        private readonly RegisteredServerRepositoryInterface $servers,
    ) {}

    public function handle(AcceptHeartbeatCommand $command): AcceptHeartbeatResult
    {
        if ($command->serverToken === '') {
            return new AcceptHeartbeatResult(
                accepted: false,
                targetCoreRef: null,
                pinned: false,
            );
        }

        $server = $this->servers->findByToken($command->serverToken);
        if ($server === null) {
            return new AcceptHeartbeatResult(
                accepted: false,
                targetCoreRef: null,
                pinned: false,
            );
        }

        $server->markSeen($command->coreRef, $command->contractVersion);
        $this->servers->save($server);

        return new AcceptHeartbeatResult(
            accepted: true,
            targetCoreRef: $server->pinnedRef,
            pinned: $server->pinnedRef !== null,
        );
    }
}

