<?php

declare(strict_types=1);

namespace App\Application\Order\Query\QuoteOrder;

use App\Application\Order\Pricing\OrderPriceCalculator;
use App\Application\Order\Query\QuoteView;

/**
 * Считает предпросмотр цены тем же калькулятором, что и оформление заказа —
 * итог гарантированно совпадёт с PlaceOrder. Заказ не создаётся, побочных эффектов нет.
 */
class QuoteOrderFetcher
{
    public function __construct(
        private readonly OrderPriceCalculator $priceCalculator,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function fetch(QuoteOrderQuery $query): array
    {
        $breakdown = $this->priceCalculator->calculate(
            venueId: $query->venueId,
            customerId: $query->customerId,
            type: $query->type,
            cartLines: $query->lines,
            promocode: $query->promocode,
            pointsToSpend: $query->pointsToSpend,
            comboLines: $query->comboLines,
        );

        return QuoteView::fromBreakdown($breakdown);
    }
}
