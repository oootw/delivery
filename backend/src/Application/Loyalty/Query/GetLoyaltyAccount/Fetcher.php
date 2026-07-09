<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Query\GetLoyaltyAccount;

use App\Application\Loyalty\Entity\Account\LoyaltyAccountRepositoryInterface;
use App\Application\Loyalty\Entity\Program\LoyaltyProgramRepositoryInterface;

/**
 * Бонусный кошелёк гостя в воркспейсе: баланс, резерв и параметры программы.
 */
class Fetcher
{
    public function __construct(
        private readonly LoyaltyProgramRepositoryInterface $programs,
        private readonly LoyaltyAccountRepositoryInterface $accounts,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function fetch(Query $query): array
    {
        $program = $this->programs->findByWorkspace($query->workspaceId);
        $account = $this->accounts->findByCustomer($query->workspaceId, $query->userId);

        return [
            'points_balance' => $account?->pointsBalance ?? 0,
            'reserved_points' => $account?->reservedPoints ?? 0,
            'available_points' => $account?->availablePoints() ?? 0,
            'program' => [
                'is_enabled' => $program?->isEnabled ?? false,
                'earn_rate_basis_points' => $program?->earnRateBasisPoints ?? 0,
                'point_value_kopecks' => $program?->pointValueKopecks ?? 100,
                'redeem_max_percent_basis_points' => $program?->redeemMaxPercentBasisPoints ?? 0,
            ],
        ];
    }
}
