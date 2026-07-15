<?php

declare(strict_types=1);

namespace App\Application\License\Contract;

use App\Application\License\ValueObject\LicenseSnapshot;

interface ControlPlaneLicenseClientInterface
{
    public function fetch(): LicenseSnapshot;
}
