<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\ChangePromotionActivity;

use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

class ChangePromotionActivityHandler
{
    public function __construct(
        private readonly PromotionRepositoryInterface $promotions,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(ChangePromotionActivityCommand $command): void
    {
        $promotion = $this->promotions->findById($command->promotionId);

        if ($promotion === null) {
            throw new \DomainException('Акция не найдена');
        }

        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $promotion->workspaceId,
            userId: $command->userId,
        );

        $promotion->changeActivity($command->isActive);

        $this->promotions->save($promotion);
    }
}
