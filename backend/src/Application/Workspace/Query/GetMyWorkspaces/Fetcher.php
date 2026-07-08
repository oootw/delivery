<?php

declare(strict_types=1);

namespace App\Application\Workspace\Query\GetMyWorkspaces;

use App\Application\Workspace\Entity\Membership\MembershipRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\Workspace;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;

class Fetcher
{
    public function __construct(
        private readonly MembershipRepositoryInterface $memberships,
        private readonly WorkspaceRepositoryInterface $workspaces,
    ) {}

    /**
     * @return WorkspaceDTO[]
     */
    public function fetch(Query $query): array
    {
        $memberships = $this->memberships->findByUser($query->userId);

        if ($memberships === []) {
            return [];
        }

        $roleByWorkspaceId = [];

        foreach ($memberships as $membership) {
            $roleByWorkspaceId[$membership->workspaceId] = $membership->role->value;
        }

        $workspaces = $this->workspaces->findAllByIds(array_keys($roleByWorkspaceId));

        return array_map(
            fn(Workspace $workspace): WorkspaceDTO => new WorkspaceDTO(
                id: $workspace->id,
                name: $workspace->name,
                slug: $workspace->slug,
                description: $workspace->description,
                role: $roleByWorkspaceId[$workspace->id],
            ),
            $workspaces,
        );
    }
}
