<?php

declare(strict_types=1);

namespace App\Application\Workspace\Command\CreateWorkspace;

use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;
use App\Application\Tarif\Service\TarifLimits;
use App\Application\Workspace\Entity\Membership\Membership;
use App\Application\Workspace\Entity\Membership\MembershipRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\Workspace;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceSlugRule;
use App\Shared\Transaction\TransactionInterface;

class CreateWorkspaceHandler
{
    public function __construct(
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly MembershipRepositoryInterface $memberships,
        private readonly SubscriptionRepositoryInterface $subscriptions,
        private readonly TarifLimits $tarifLimits,
        private readonly WorkspaceSlugRule $slugRule,
        private readonly TransactionInterface $transaction,
    ) {}

    public function handle(CreateWorkspaceCommand $command): CreatedWorkspaceDTO
    {
        $subscription = $this->subscriptions->findActiveByUser($command->ownerId);

        if ($subscription === null) {
            throw new \DomainException('Требуется активная подписка');
        }

        $ownedCount = $this->workspaces->countByOwner($command->ownerId);

        if ($ownedCount >= $this->tarifLimits->maxWorkspaces($subscription->tarifCode)) {
            throw new \DomainException('Достигнут лимит воркспейсов по тарифу');
        }

        $this->slugRule->validate($command->slug);

        if ($this->workspaces->findBySlug($command->slug) !== null) {
            throw new \DomainException('Slug уже занят');
        }

        $workspace = Workspace::buildNew(
            name: $command->name,
            slug: $command->slug,
            description: $command->description,
            ownerId: $command->ownerId,
        );

        // Воркспейс и owner-membership создаём атомарно — иначе возможен осиротевший воркспейс без владельца.
        $workspaceId = $this->transaction->wrap(function () use ($workspace, $command): int {
            $workspaceId = $this->workspaces->save($workspace);

            $this->memberships->save(
                Membership::buildOwner(
                    workspaceId: $workspaceId,
                    userId: $command->ownerId,
                ),
            );

            return $workspaceId;
        });

        return new CreatedWorkspaceDTO(
            id: $workspaceId,
            slug: $workspace->slug,
        );
    }
}
