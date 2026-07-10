<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Query\GetLoyaltyAccount;

use App\Application\Loyalty\Entity\Account\LoyaltyAccountRepositoryInterface;
use App\Application\Loyalty\Entity\Program\LoyaltyProgramRepositoryInterface;
use App\Application\Loyalty\Entity\Stamp\StampProgramRepositoryInterface;
use App\Application\Loyalty\Entity\Stamp\StampProgressRepositoryInterface;
use App\Application\Loyalty\Entity\Tier\LoyaltyTier;
use App\Application\Loyalty\Entity\Tier\LoyaltyTierRepositoryInterface;
use App\Application\Loyalty\Service\TierResolver;

/**
 * Бонусный кошелёк гостя в воркспейсе: баланс, резерв, параметры программы, текущий
 * уровень и прогресс до следующего (по сумме трат за всё время), прогресс карты штампов.
 */
class Fetcher
{
    public function __construct(
        private readonly LoyaltyProgramRepositoryInterface $programs,
        private readonly LoyaltyAccountRepositoryInterface $accounts,
        private readonly LoyaltyTierRepositoryInterface $tiers,
        private readonly TierResolver $tierResolver,
        private readonly StampProgramRepositoryInterface $stampPrograms,
        private readonly StampProgressRepositoryInterface $stampProgress,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function fetch(Query $query): array
    {
        $program = $this->programs->findByWorkspace($query->workspaceId);
        $account = $this->accounts->findByCustomer($query->workspaceId, $query->userId);
        $tiers = $this->tiers->findByWorkspace($query->workspaceId);

        $lifetimeSpent = $account?->lifetimeSpentKopecks ?? 0;
        $currentTier = $this->tierResolver->resolve($lifetimeSpent, $tiers);
        $nextTier = $this->tierResolver->nextTier($lifetimeSpent, $tiers);

        return [
            'points_balance' => $account?->pointsBalance ?? 0,
            'reserved_points' => $account?->reservedPoints ?? 0,
            'available_points' => $account?->availablePoints() ?? 0,
            'lifetime_spent_kopecks' => $lifetimeSpent,
            'program' => [
                'is_enabled' => $program?->isEnabled ?? false,
                'earn_rate_basis_points' => $program?->earnRateBasisPoints ?? 0,
                'point_value_kopecks' => $program?->pointValueKopecks ?? 100,
                'redeem_max_percent_basis_points' => $program?->redeemMaxPercentBasisPoints ?? 0,
            ],
            'current_tier' => $this->tierToArray($currentTier),
            'next_tier' => $this->tierToArray($nextTier),
            'kopecks_to_next_tier' => $nextTier !== null ? max(0, $nextTier->thresholdKopecks - $lifetimeSpent) : null,
            'tiers' => array_map(fn(LoyaltyTier $tier): array => $this->tierToArray($tier), $tiers),
            'stamps' => $this->stampsBlock($query->workspaceId, $query->userId),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function stampsBlock(int $workspaceId, int $customerId): array
    {
        $program = $this->stampPrograms->findByWorkspace($workspaceId);

        if ($program === null || !$program->isEnabled) {
            return ['is_enabled' => false];
        }

        $progress = $this->stampProgress->findByCustomer($workspaceId, $customerId);
        $current = $progress?->currentStamps ?? 0;

        return [
            'is_enabled' => true,
            'required_count' => $program->requiredCount,
            'reward_points' => $program->rewardPoints,
            'current_stamps' => $current,
            'stamps_to_reward' => max(0, $program->requiredCount - $current),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function tierToArray(?LoyaltyTier $tier): ?array
    {
        if ($tier === null) {
            return null;
        }

        return [
            'name' => $tier->name,
            'threshold_kopecks' => $tier->thresholdKopecks,
            'earn_rate_bonus_basis_points' => $tier->earnRateBonusBasisPoints,
            'permanent_discount_basis_points' => $tier->permanentDiscountBasisPoints,
            'sort_order' => $tier->sortOrder,
        ];
    }
}
