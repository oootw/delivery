<?php

declare(strict_types=1);

namespace App\Application\Tarif\Entity\Tarif;

enum TarifCodeEnum: string
{
    case BASIC = 'basic';
    case PRO = 'pro';
    case ENTERPRISE = 'enterprise';
}
