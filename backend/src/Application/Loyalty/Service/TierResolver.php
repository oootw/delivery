<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Service;

use App\Application\Loyalty\Entity\Tier\LoyaltyTier;

/**
 * Чистый резолвер уровня гостя: по сумме трат за всё время возвращает самый высокий
 * уровень, порог которого не превышает траты. Если подходящих нет — null (базовый
 * уровень без бонусов).
 */
class TierResolver
{
    /**
     * @param LoyaltyTier[] $tiers
     */
    public function resolve(int $lifetimeSpentKopecks, array $tiers): ?LoyaltyTier
    {
        $current = null;

        foreach ($tiers as $tier) {
            if ($tier->thresholdKopecks > $lifetimeSpentKopecks) {
                continue;
            }

            if ($current === null || $tier->thresholdKopecks > $current->thresholdKopecks) {
                $current = $tier;
            }
        }

        return $current;
    }

    /**
     * Ближайший более высокий уровень (для прогресса «до следующего уровня»).
     *
     * @param LoyaltyTier[] $tiers
     */
    public function nextTier(int $lifetimeSpentKopecks, array $tiers): ?LoyaltyTier
    {
        $next = null;

        foreach ($tiers as $tier) {
            if ($tier->thresholdKopecks <= $lifetimeSpentKopecks) {
                continue;
            }

            if ($next === null || $tier->thresholdKopecks < $next->thresholdKopecks) {
                $next = $tier;
            }
        }

        return $next;
    }
}
