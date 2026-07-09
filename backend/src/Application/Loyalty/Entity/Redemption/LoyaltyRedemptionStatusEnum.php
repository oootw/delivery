<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Redemption;

enum LoyaltyRedemptionStatusEnum: string
{
    /** Баллы зарезервированы под неоплаченный заказ. */
    case Reserved = 'reserved';

    /** Заказ оплачен — баллы списаны. */
    case Finalized = 'finalized';

    /** Заказ отменён до оплаты — резерв возвращён. */
    case Released = 'released';

    /** Заказ отменён после оплаты — списанные баллы возвращены. */
    case Refunded = 'refunded';
}
