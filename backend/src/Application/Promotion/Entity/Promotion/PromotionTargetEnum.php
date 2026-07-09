<?php

declare(strict_types=1);

namespace App\Application\Promotion\Entity\Promotion;

enum PromotionTargetEnum: string
{
    /** Скидка на всю сумму заказа. */
    case Order = 'order';

    /** Скидка на конкретные позиции меню (targetRefs — externalId позиций). */
    case Item = 'item';

    /** Скидка на позиции категорий меню (targetRefs — externalId категорий). */
    case Category = 'category';
}
