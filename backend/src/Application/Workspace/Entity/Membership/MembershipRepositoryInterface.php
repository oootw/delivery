<?php

declare(strict_types=1);

namespace App\Application\Workspace\Entity\Membership;

interface MembershipRepositoryInterface
{
    public function save(Membership $membership): int;

    public function findByWorkspaceAndUser(int $workspaceId, int $userId): ?Membership;

    /**
     * @return Membership[]
     */
    public function findByUser(int $userId): array;

    public function delete(int $membershipId): void;
}
