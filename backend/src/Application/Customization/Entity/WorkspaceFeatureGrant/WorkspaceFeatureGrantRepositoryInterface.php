<?php

declare(strict_types=1);

namespace App\Application\Customization\Entity\WorkspaceFeatureGrant;

use App\Shared\Enum\Feature\FeatureCodeEnum;

interface WorkspaceFeatureGrantRepositoryInterface
{
    public function save(WorkspaceFeatureGrant $grant): int;

    public function findByWorkspaceAndFeature(int $workspaceId, FeatureCodeEnum $feature): ?WorkspaceFeatureGrant;

    /**
     * Выданные воркспейсу фичи — вход для FeatureGate.
     *
     * @return list<FeatureCodeEnum>
     */
    public function grantedFeatures(int $workspaceId): array;
}
