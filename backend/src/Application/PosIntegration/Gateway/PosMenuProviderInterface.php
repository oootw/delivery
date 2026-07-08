<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Gateway;

use App\Application\PosIntegration\Entity\PosConnection\PosConnection;
use App\Application\PosIntegration\Entity\PosConnection\PosSystemEnum;

/**
 * Порт получения меню из POS-системы. Под каждую систему — свой адаптер;
 * выбор адаптера — по PosSystemEnum (см. supports()).
 */
interface PosMenuProviderInterface
{
    public function supports(PosSystemEnum $posSystem): bool;

    public function fetchMenu(PosConnection $connection): PosMenuSnapshot;
}
