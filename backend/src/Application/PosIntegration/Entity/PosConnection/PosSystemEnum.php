<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Entity\PosConnection;

enum PosSystemEnum: string
{
    case Iiko = 'iiko';
    case Rkeeper = 'rkeeper';
}
