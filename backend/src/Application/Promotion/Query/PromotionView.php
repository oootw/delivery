<?php

declare(strict_types=1);

namespace App\Application\Promotion\Query;

use App\Application\Promotion\Entity\Promotion\Promotion;

/**
 * Read-model акции для ответов API управления.
 */
final class PromotionView
{
    /**
     * @return array<string, mixed>
     */
    public static function fromPromotion(Promotion $promotion): array
    {
        return [
            'id' => $promotion->id,
            'workspace_id' => $promotion->workspaceId,
            'venue_id' => $promotion->venueId,
            'name' => $promotion->name,
            'type' => $promotion->type->value,
            'code' => $promotion->code,
            'reward_type' => $promotion->rewardType->value,
            'reward_value' => $promotion->rewardValue,
            'target' => $promotion->target->value,
            'target_refs' => $promotion->targetRefs,
            'conditions' => $promotion->conditions->toArray(),
            'priority' => $promotion->priority,
            'stackable' => $promotion->stackable,
            'max_redemptions' => $promotion->maxRedemptions,
            'max_redemptions_per_customer' => $promotion->maxRedemptionsPerCustomer,
            'redemptions_count' => $promotion->redemptionsCount,
            'is_active' => $promotion->isActive,
            'created_at' => $promotion->createdAt->format(\DateTimeInterface::ATOM),
            'updated_at' => $promotion->updatedAt->format(\DateTimeInterface::ATOM),
        ];
    }
}
