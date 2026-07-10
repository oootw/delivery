<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Command\SetStampProgram;

use App\Application\Loyalty\Entity\Stamp\StampProgram;
use App\Application\Loyalty\Entity\Stamp\StampProgramRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Настройка программы штампов воркспейса владельцем. Программа одна на воркспейс —
 * создаётся при первом сохранении, дальше обновляется.
 */
class Handler
{
    public function __construct(
        private readonly StampProgramRepositoryInterface $stampPrograms,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(Command $command): void
    {
        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $command->workspaceId,
            userId: $command->ownerId,
        );

        $program = $this->stampPrograms->findByWorkspace($command->workspaceId)
            ?? StampProgram::buildNew($command->workspaceId);

        $program->update(
            isEnabled: $command->isEnabled,
            requiredCount: $command->requiredCount,
            rewardPoints: $command->rewardPoints,
        );

        $this->stampPrograms->save($program);
    }
}
