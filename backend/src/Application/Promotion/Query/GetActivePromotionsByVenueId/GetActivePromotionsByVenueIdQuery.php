<?php

declare(strict_types=1);

namespace App\Application\Promotion\Query\GetActivePromotionsByVenueId;

/**
 * Запрос витрины акций точки для гостя. Показываются только активные автоматические
 * акции — промокоды остаются секретом и в списке не отдаются.
 */
class GetActivePromotionsByVenueIdQuery
{
    public function __construct(
        public readonly int $venueId,
    ) {}
}
