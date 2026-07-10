<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Stamp;

interface StampProgramRepositoryInterface
{
    public function save(StampProgram $program): int;

    public function findByWorkspace(int $workspaceId): ?StampProgram;
}
