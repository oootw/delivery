<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Tier;

interface LoyaltyTierRepositoryInterface
{
    /**
     * Уровни воркспейса по возрастанию порога.
     *
     * @return LoyaltyTier[]
     */
    public function findByWorkspace(int $workspaceId): array;

    /**
     * Полная замена набора уровней воркспейса (для настройки владельцем).
     *
     * @param LoyaltyTier[] $tiers
     */
    public function replaceAll(int $workspaceId, array $tiers): void;
}
