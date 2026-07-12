<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\SetPromotionBanner;

use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Задаёт заголовок и текст баннера акции. Менять может только владелец воркспейса.
 */
class SetPromotionBannerHandler
{
    public function __construct(
        private readonly PromotionRepositoryInterface $promotions,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(SetPromotionBannerCommand $command): void
    {
        $promotion = $this->promotions->findById($command->promotionId);

        if ($promotion === null) {
            throw new \DomainException('Акция не найдена');
        }

        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $promotion->workspaceId,
            userId: $command->userId,
        );

        $promotion->setBanner(
            bannerTitle: $command->bannerTitle,
            bannerText: $command->bannerText,
        );

        $this->promotions->save($promotion);
    }
}
