<?php

declare(strict_types=1);

namespace App\Application\License\ValueObject;

use App\Application\License\Enum\LicenseStatusEnum;
use App\Application\Tarif\Entity\Tarif\TarifCodeEnum;
use App\Shared\Enum\Feature\FeatureCodeEnum;

final class ServerLicenseRecord
{
    /**
     * @param list<FeatureCodeEnum> $features
     */
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly TarifCodeEnum $tarifCode,
        public readonly array $features,
        public readonly LicenseStatusEnum $status,
        public readonly ?\DateTimeImmutable $validUntil,
    ) {}
}
