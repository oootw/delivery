<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\Combo;

/**
 * Как считается скидка комбо от суммы вложенных товаров:
 * Percent — процент (discountValue 0..100), Fixed — фиксированная сумма в копейках.
 */
enum ComboDiscountTypeEnum: string
{
    case Percent = 'percent';
    case Fixed = 'fixed';
}
