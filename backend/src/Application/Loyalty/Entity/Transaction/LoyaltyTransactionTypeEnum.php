<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Transaction;

/**
 * Тип движения баланса в леджере. Резерв/освобождение баланс не меняют и
 * отражаются в LoyaltyRedemption, а не здесь.
 */
enum LoyaltyTransactionTypeEnum: string
{
    /** Начисление кэшбэка за завершённый заказ. */
    case Earn = 'earn';

    /** Списание баллов при оплате заказа. */
    case RedeemFinalize = 'redeem_finalize';

    /** Возврат списанных баллов при отмене оплаченного заказа. */
    case Refund = 'refund';

    /** Ручная корректировка баланса (поддержкой/владельцем). */
    case ManualAdjust = 'manual_adjust';

    /** Баллы, выданные за заполненную карту штампов. */
    case StampReward = 'stamp_reward';

    /** Сгорание баллов по сроку жизни (pointsLifetimeDays). */
    case Expire = 'expire';
}
