<?php

declare(strict_types=1);

namespace App\Application\Promotion\Query\GetPromotionById;

use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;
use App\Application\Promotion\Query\PromotionView;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Одна акция по id. Доступна любому участнику воркспейса-владельца акции.
 */
class GetPromotionByIdFetcher
{
    public function __construct(
        private readonly PromotionRepositoryInterface $promotions,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function fetch(GetPromotionByIdQuery $query): array
    {
        $promotion = $this->promotions->findById($query->promotionId);

        if ($promotion === null) {
            throw new \DomainException('Акция не найдена');
        }

        $this->workspaceAccess->requireMember(
            workspaceId: $promotion->workspaceId,
            userId: $query->userId,
        );

        return PromotionView::fromPromotion($promotion);
    }
}
