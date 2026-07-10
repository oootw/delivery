<?php

declare(strict_types=1);

namespace App\Application\Order\Rewards;

/**
 * Постоянная скидка уровня лояльности гостя для расчёта заказа. Процент в базисных
 * пунктах; название уровня — для разбивки скидок в заказе. Пустой уровень — 0/null.
 */
final class TierDiscount
{
    public function __construct(
        public readonly int $basisPoints,
        public readonly ?string $tierName,
    ) {}

    public static function none(): self
    {
        return new self(0, null);
    }
}
