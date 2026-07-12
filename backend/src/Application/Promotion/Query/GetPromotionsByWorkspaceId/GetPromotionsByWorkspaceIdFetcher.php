<?php

declare(strict_types=1);

namespace App\Application\Promotion\Query\GetPromotionsByWorkspaceId;

use App\Application\Promotion\Entity\Promotion\Promotion;
use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;
use App\Application\Promotion\Query\PromotionView;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Список акций воркспейса. Доступен любому участнику воркспейса.
 */
class GetPromotionsByWorkspaceIdFetcher
{
    public function __construct(
        private readonly PromotionRepositoryInterface $promotions,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetch(GetPromotionsByWorkspaceIdQuery $query): array
    {
        $this->workspaceAccess->requireMember(
            workspaceId: $query->workspaceId,
            userId: $query->userId,
        );

        return array_map(
            static fn(Promotion $promotion): array => PromotionView::fromPromotion($promotion),
            $this->promotions->findAllByWorkspace($query->workspaceId),
        );
    }
}
