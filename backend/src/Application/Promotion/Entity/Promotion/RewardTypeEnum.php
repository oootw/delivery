<?php

declare(strict_types=1);

namespace App\Application\Promotion\Entity\Promotion;

enum RewardTypeEnum: string
{
    /** Процент от базы, значение в базисных пунктах (10000 = 100%). */
    case Percent = 'percent';

    /** Фиксированная скидка в копейках. */
    case FixedAmount = 'fixed_amount';
}
