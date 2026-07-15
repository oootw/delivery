<?php

declare(strict_types=1);

namespace App\Application\Customization\Feature;

use App\Application\Customization\Entity\WorkspaceFeatureGrant\WorkspaceFeatureGrantRepositoryInterface;
use App\Application\Customization\Registry\CustomModuleRegistry;
use App\Application\License\Contract\LicenseProviderInterface;
use App\Application\License\Enum\LicenseStatusEnum;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;
use App\Shared\Enum\Feature\FeatureCodeEnum;

/**
 * Реализация единого гейта возможностей.
 *
 * Источник 1 — закэшированная лицензия control-plane (тариф + набор features).
 * Источник 2 — активные клиентские модули сервера (их capabilities()).
 * Источник 3 — точечные гранты (workspace_feature_grant), путь «доплатил → включили».
 *
 * Доступ = объединение источников. Всё по workspace_id — устойчиво к смене любых slug.
 */
final class FeatureGate implements FeatureGateInterface
{
    public function __construct(
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly LicenseProviderInterface $licenseProvider,
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
        if ($this->workspaces->findById($workspaceId) === null) {
            return [];
        }

        try {
            $license = $this->licenseProvider->getSnapshot();
        } catch (\Throwable) {
            return [];
        }

        if ($license->status !== LicenseStatusEnum::Active) {
            return [];
        }

        return $license->features;
    }

    /**
     * @return list<FeatureCodeEnum>
     */
    private function moduleFeatures(int $workspaceId): array
    {
        if ($this->workspaces->findById($workspaceId) === null) {
            return [];
        }

        $features = [];

        foreach ($this->modules->all() as $module) {
            foreach ($module->capabilities() as $feature) {
                $features[] = $feature;
            }
        }

        return $features;
    }
}
