<?php

declare(strict_types=1);

namespace App\Application\Customization\Feature;

use App\Application\Customization\Entity\WorkspaceFeatureGrant\WorkspaceFeatureGrantRepositoryInterface;
use App\Application\Customization\Registry\CustomModuleRegistry;
use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;
use App\Application\Tarif\Entity\Tarif\TarifRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;
use App\Shared\Enum\Feature\FeatureCodeEnum;

/**
 * Реализация единого гейта возможностей.
 *
 * Источник 1 — тариф: воркспейс → владелец (Workspace.ownerId) → активная подписка
 *   (findActiveByUser) → тариф → его features. Неактивная/просроченная подписка фич не даёт.
 * Источник 2 — активные клиентские модули воркспейса (их capabilities()).
 * Источник 3 — точечные гранты (workspace_feature_grant), путь «доплатил → включили».
 *
 * Доступ = объединение источников. Всё по workspace_id — устойчиво к смене любых slug.
 */
final class FeatureGate implements FeatureGateInterface
{
    public function __construct(
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly SubscriptionRepositoryInterface $subscriptions,
        private readonly TarifRepositoryInterface $tarifs,
        private readonly CustomModuleRegistry $modules,
        private readonly WorkspaceFeatureGrantRepositoryInterface $grants,
    ) {}

    public function has(int $workspaceId, FeatureCodeEnum $feature): bool
    {
        return in_array($feature, $this->tarifFeatures($workspaceId), true)
            || in_array($feature, $this->moduleFeatures($workspaceId), true)
            || in_array($feature, $this->grants->grantedFeatures($workspaceId), true);
    }

    public function enabledFor(int $workspaceId): array
    {
        $features = [
            ...$this->tarifFeatures($workspaceId),
            ...$this->moduleFeatures($workspaceId),
            ...$this->grants->grantedFeatures($workspaceId),
        ];

        return array_values(array_unique($features, \SORT_REGULAR));
    }

    /**
     * @return list<FeatureCodeEnum>
     */
    private function tarifFeatures(int $workspaceId): array
    {
        $workspace = $this->workspaces->findById($workspaceId);

        if ($workspace === null) {
            return [];
        }

        $subscription = $this->subscriptions->findActiveByUser($workspace->ownerId);

        if ($subscription === null) {
            return [];
        }

        $tarif = $this->tarifs->getByTarifCode($subscription->tarifCode);

        return $tarif?->features ?? [];
    }

    /**
     * @return list<FeatureCodeEnum>
     */
    private function moduleFeatures(int $workspaceId): array
    {
        $features = [];

        foreach ($this->modules->activeFor($workspaceId) as $module) {
            foreach ($module->capabilities() as $feature) {
                $features[] = $feature;
            }
        }

        return $features;
    }
}
