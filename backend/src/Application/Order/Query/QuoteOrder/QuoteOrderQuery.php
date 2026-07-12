<?php

declare(strict_types=1);

namespace App\Application\Order\Query\QuoteOrder;

use App\Application\Order\Pricing\CartLine;
use App\Application\Order\Pricing\ComboCartLine;

/**
 * Запрос предпросмотра цены заказа: та же корзина, что и при оформлении, но без
 * создания заказа. customerId нужен для баллов, уровня и признака «первый заказ».
 */
class QuoteOrderQuery
{
    /**
     * @param CartLine[] $lines
     * @param ComboCartLine[] $comboLines
     */
    public function __construct(
        public readonly int $venueId,
        public readonly int $customerId,
        public readonly string $type,
        public readonly array $lines,
        public readonly ?string $promocode,
        public readonly ?int $pointsToSpend,
        public readonly array $comboLines = [],
    ) {}
}
