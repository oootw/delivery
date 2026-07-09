<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\UpdatePromotion;

use App\Application\Promotion\Entity\Promotion\Promotion;
use App\Application\Promotion\Entity\Promotion\PromotionConditions;
use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;
use App\Application\Promotion\Entity\Promotion\PromotionTargetEnum;
use App\Application\Promotion\Entity\Promotion\PromotionTypeEnum;
use App\Application\Promotion\Entity\Promotion\RewardTypeEnum;
use App\Application\Workspace\Service\WorkspaceAccess;

class Handler
{
    public function __construct(
        private readonly PromotionRepositoryInterface $promotions,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(Command $command): void
    {
        $promotion = $this->promotions->findById($command->promotionId);

        if ($promotion === null) {
            throw new \DomainException('Акция не найдена');
        }

        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $promotion->workspaceId,
            userId: $command->userId,
        );

        $type = PromotionTypeEnum::tryFrom($command->type);

        if ($type === null) {
            throw new \DomainException('Неизвестный тип акции');
        }

        $rewardType = RewardTypeEnum::tryFrom($command->rewardType);

        if ($rewardType === null) {
            throw new \DomainException('Неизвестный тип скидки');
        }

        $target = PromotionTargetEnum::tryFrom($command->target);

        if ($target === null) {
            throw new \DomainException('Неизвестная цель скидки');
        }

        if ($type === PromotionTypeEnum::Promocode && $command->code !== null && $command->code !== '') {
            $existing = $this->promotions->findActivePromocode(
                $promotion->workspaceId,
                Promotion::normalizeCode($command->code),
            );

            if ($existing !== null && $existing->id !== $promotion->id) {
                throw new \DomainException('Такой промокод уже существует');
            }
        }

        $promotion->update(
            name: $command->name,
            type: $type,
            code: $command->code,
            rewardType: $rewardType,
            rewardValue: $command->rewardValue,
            target: $target,
            targetRefs: $command->targetRefs,
            conditions: PromotionConditions::fromArray($command->conditions),
            priority: $command->priority,
            stackable: $command->stackable,
            maxRedemptions: $command->maxRedemptions,
            maxRedemptionsPerCustomer: $command->maxRedemptionsPerCustomer,
        );

        $this->promotions->save($promotion);
    }
}
