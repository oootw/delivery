<?php

declare(strict_types=1);

namespace App\Application\Promotion\Query\GetActivePromotionsByVenueId;

use App\Application\Promotion\Entity\Promotion\Promotion;
use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;
use App\Application\Promotion\Query\PublicPromotionView;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;

/**
 * Витрина акций точки: активные автоматические акции воркспейса, применимые к точке.
 * Доступна любому авторизованному клиенту (как и просмотр меню).
 */
class GetActivePromotionsByVenueIdFetcher
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly PromotionRepositoryInterface $promotions,
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetch(GetActivePromotionsByVenueIdQuery $query): array
    {
        $venue = $this->venues->findById($query->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        return array_map(
            static fn(Promotion $promotion): array => PublicPromotionView::fromPromotion($promotion),
            $this->promotions->findActiveAutomaticByVenue($venue->workspaceId, $venue->id),
        );
    }
}
