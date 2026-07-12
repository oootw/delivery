<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Command\SetStampProgram;

class SetStampProgramCommand
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly bool $isEnabled,
        public readonly int $requiredCount,
        public readonly int $rewardPoints,
    ) {}
}
