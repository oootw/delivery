<?php

declare(strict_types=1);

namespace App\Application\License\Registry;

use App\Application\License\ValueObject\ServerLicenseRecord;

interface ServerLicenseRegistryInterface
{
    public function findByToken(string $serverToken): ?ServerLicenseRecord;
}
