<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Program;

interface LoyaltyProgramRepositoryInterface
{
    public function save(LoyaltyProgram $program): int;

    public function findByWorkspace(int $workspaceId): ?LoyaltyProgram;

    /**
     * Включённые программы со сроком жизни баллов — для крон-экспирации.
     *
     * @return LoyaltyProgram[]
     */
    public function findAllWithExpiry(): array;
}
