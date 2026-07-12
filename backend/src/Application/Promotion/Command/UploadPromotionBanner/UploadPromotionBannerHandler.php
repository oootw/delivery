<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\UploadPromotionBanner;

use App\Application\Promotion\Banner\PromotionBannerStorageInterface;
use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Загружает картинку баннера акции. Загружать может только владелец воркспейса.
 */
class UploadPromotionBannerHandler
{
    public function __construct(
        private readonly PromotionRepositoryInterface $promotions,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly PromotionBannerStorageInterface $banners,
    ) {}

    public function handle(UploadPromotionBannerCommand $command): string
    {
        $promotion = $this->promotions->findById($command->promotionId);

        if ($promotion === null) {
            throw new \DomainException('Акция не найдена');
        }

        $workspace = $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $promotion->workspaceId,
            userId: $command->userId,
        );

        return $this->banners->store(
            slug: $workspace->slug,
            promotionId: $promotion->id,
            sourcePath: $command->sourcePath,
            extension: $command->extension,
        );
    }
}
