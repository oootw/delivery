<?php

declare(strict_types=1);

namespace App\Application\Server\Entity\RegisteredServer;

interface RegisteredServerRepositoryInterface
{
    public function save(RegisteredServer $server): int;

    public function findByToken(string $serverToken): ?RegisteredServer;

    public function findByOwnerAndDomain(string $ownerSlug, string $domain): ?RegisteredServer;

    /**
     * @return list<RegisteredServer>
     */
    public function findAll(): array;
}

