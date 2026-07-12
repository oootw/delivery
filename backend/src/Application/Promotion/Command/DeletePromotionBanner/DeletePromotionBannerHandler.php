<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\DeletePromotionBanner;

use App\Application\Promotion\Banner\PromotionBannerStorageInterface;
use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Удаляет картинку баннера акции. Может только владелец воркспейса.
 */
class DeletePromotionBannerHandler
{
    public function __construct(
        private readonly PromotionRepositoryInterface $promotions,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly PromotionBannerStorageInterface $banners,
    ) {}

    public function handle(DeletePromotionBannerCommand $command): void
    {
        $promotion = $this->promotions->findById($command->promotionId);

        if ($promotion === null) {
            throw new \DomainException('Акция не найдена');
        }

        $workspace = $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $promotion->workspaceId,
            userId: $command->userId,
        );

        $this->banners->delete(
            slug: $workspace->slug,
            promotionId: $promotion->id,
        );
    }
}
