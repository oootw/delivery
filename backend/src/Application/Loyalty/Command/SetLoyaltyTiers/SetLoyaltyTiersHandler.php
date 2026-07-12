<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Command\SetLoyaltyTiers;

use App\Application\Loyalty\Entity\Tier\LoyaltyTier;
use App\Application\Loyalty\Entity\Tier\LoyaltyTierRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Настройка набора уровней лояльности воркспейса владельцем. Набор заменяется целиком.
 * Пороги уровней должны быть уникальны — иначе резолвер уровня был бы неоднозначным.
 */
class SetLoyaltyTiersHandler
{
    public function __construct(
        private readonly LoyaltyTierRepositoryInterface $tiers,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(SetLoyaltyTiersCommand $command): void
    {
        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $command->workspaceId,
            userId: $command->ownerId,
        );

        $tiers = [];
        $seenThresholds = [];

        foreach ($command->tiers as $tier) {
            $threshold = $tier['threshold_kopecks'];

            if (isset($seenThresholds[$threshold])) {
                throw new \DomainException('Пороги уровней должны быть уникальны');
            }

            $seenThresholds[$threshold] = true;

            $tiers[] = LoyaltyTier::buildNew(
                workspaceId: $command->workspaceId,
                name: $tier['name'],
                thresholdKopecks: $threshold,
                earnRateBonusBasisPoints: $tier['earn_rate_bonus_basis_points'],
                permanentDiscountBasisPoints: $tier['permanent_discount_basis_points'],
                sortOrder: $tier['sort_order'],
            );
        }

        $this->tiers->replaceAll($command->workspaceId, $tiers);
    }
}
