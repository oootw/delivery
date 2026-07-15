<?php

declare(strict_types=1);

namespace App\Application\License\Service;

use App\Application\Tarif\Entity\Tarif\TarifCodeEnum;
use App\Shared\Enum\Feature\FeatureCodeEnum;

final class TarifFeatureCatalog
{
    /**
     * @return list<FeatureCodeEnum>
     */
    public function byTarifCode(TarifCodeEnum $tarifCode): array
    {
        return match ($tarifCode) {
            TarifCodeEnum::BASIC => [
                FeatureCodeEnum::POINTS,
            ],
            TarifCodeEnum::PRO => [
                FeatureCodeEnum::POINTS,
                FeatureCodeEnum::CRM,
                FeatureCodeEnum::ANALYTICS,
            ],
            TarifCodeEnum::ENTERPRISE => [
                FeatureCodeEnum::POINTS,
                FeatureCodeEnum::CRM,
                FeatureCodeEnum::ANALYTICS,
                FeatureCodeEnum::SUPPORT,
                FeatureCodeEnum::CUSTOMIZATION,
            ],
        };
    }
}
