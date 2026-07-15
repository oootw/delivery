<?php

declare(strict_types=1);

namespace App\Application\Server\Command\RegisterServer;

use App\Application\Server\Entity\RegisteredServer\RegisteredServer;
use App\Application\Server\Entity\RegisteredServer\RegisteredServerRepositoryInterface;

final class RegisterServerHandler
{
    public function __construct(
        private readonly RegisteredServerRepositoryInterface $servers,
    ) {}

    public function handle(RegisterServerCommand $command): RegisterServerResult
    {
        if ($command->ownerSlug === '') {
            throw new \DomainException('owner_slug не может быть пустым');
        }

        if ($command->domain === '') {
            throw new \DomainException('domain не может быть пустым');
        }

        $existing = $this->servers->findByOwnerAndDomain($command->ownerSlug, $command->domain);
        if ($existing !== null) {
            $existing->markSeen($command->coreRef, $command->contractVersion);
            $this->servers->save($existing);

            return new RegisterServerResult(
                ownerId: $existing->ownerId,
                workspaceId: $existing->workspaceId,
                serverToken: $existing->serverToken,
            );
        }

        $ownerId = $this->ownerIdFromSlug($command->ownerSlug);
        $workspaceId = $this->workspaceIdFromOwnerId($ownerId);
        $token = $this->generateServerToken($command->ownerSlug, $command->domain);

        $server = RegisteredServer::buildNew(
            ownerSlug: $command->ownerSlug,
            domain: $command->domain,
            ownerId: $ownerId,
            workspaceId: $workspaceId,
            serverToken: $token,
            coreRef: $command->coreRef,
            contractVersion: $command->contractVersion,
        );

        $this->servers->save($server);

        return new RegisterServerResult(
            ownerId: $ownerId,
            workspaceId: $workspaceId,
            serverToken: $token,
        );
    }

    /**
     * До внедрения отдельного owner-каталога используем детерминированный идентификатор.
     */
    private function ownerIdFromSlug(string $ownerSlug): int
    {
        return max(1, abs(crc32($ownerSlug)) % 1000000);
    }

    private function workspaceIdFromOwnerId(int $ownerId): int
    {
        return $ownerId + 1000000;
    }

    private function generateServerToken(string $ownerSlug, string $domain): string
    {
        return hash('sha256', $ownerSlug . ':' . $domain . ':' . microtime(true) . ':' . random_int(1, PHP_INT_MAX));
    }
}

