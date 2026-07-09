<?php

declare(strict_types=1);

namespace App\Application\Promotion\Entity\Promotion;

enum PromotionTypeEnum: string
{
    /** Скидка применяется автоматически, если выполнены условия. */
    case Automatic = 'automatic';

    /** Скидка применяется только при вводе промокода. */
    case Promocode = 'promocode';
}
