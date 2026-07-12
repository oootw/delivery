<?php

declare(strict_types=1);

namespace App\Application\Promotion\Query;

use App\Application\Promotion\Entity\Promotion\Promotion;

/**
 * Витринный read-model акции для гостя. Отдаёт только то, что уместно показать
 * в каталоге акций: без промокодов, лимитов, счётчиков и приоритетов.
 */
final class PublicPromotionView
{
    /**
     * @return array<string, mixed>
     */
    public static function fromPromotion(Promotion $promotion): array
    {
        return [
            'id' => $promotion->id,
            'name' => $promotion->name,
            'reward_type' => $promotion->rewardType->value,
            'reward_value' => $promotion->rewardValue,
            'target' => $promotion->target->value,
            'target_refs' => $promotion->targetRefs,
            'conditions' => $promotion->conditions->toArray(),
            'stackable' => $promotion->stackable,
        ];
    }
}
