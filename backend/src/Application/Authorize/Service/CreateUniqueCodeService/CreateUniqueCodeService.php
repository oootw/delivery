<?php

declare(strict_types=1);

namespace App\Application\Authorize\Service\CreateUniqueCodeService;

class CreateUniqueCodeService
{
    public function createUniqueCode(): string
    {
        $n = random_int(0, 9999);

        return sprintf('%04d', $n);
    }
}
