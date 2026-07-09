<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Command\SetLoyaltyProgram;

use App\Application\Loyalty\Entity\Program\LoyaltyProgram;
use App\Application\Loyalty\Entity\Program\LoyaltyProgramRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Настройка бонусной программы воркспейса владельцем. Программа одна на воркспейс —
 * создаётся при первом сохранении, дальше обновляется.
 */
class Handler
{
    public function __construct(
        private readonly LoyaltyProgramRepositoryInterface $programs,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(Command $command): void
    {
        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $command->workspaceId,
            userId: $command->ownerId,
        );

        $program = $this->programs->findByWorkspace($command->workspaceId)
            ?? LoyaltyProgram::buildNew($command->workspaceId);

        $program->update(
            isEnabled: $command->isEnabled,
            earnRateBasisPoints: $command->earnRateBasisPoints,
            pointValueKopecks: $command->pointValueKopecks,
            redeemMaxPercentBasisPoints: $command->redeemMaxPercentBasisPoints,
            pointsLifetimeDays: $command->pointsLifetimeDays,
        );

        $this->programs->save($program);
    }
}
