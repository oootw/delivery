<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\DeletePromotion;

use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

class DeletePromotionHandler
{
    public function __construct(
        private readonly PromotionRepositoryInterface $promotions,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(DeletePromotionCommand $command): void
    {
        $promotion = $this->promotions->findById($command->promotionId);

        if ($promotion === null) {
            throw new \DomainException('Акция не найдена');
        }

        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $promotion->workspaceId,
            userId: $command->userId,
        );

        $this->promotions->delete($promotion);
    }
}
