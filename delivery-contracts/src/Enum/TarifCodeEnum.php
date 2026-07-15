<?php

declare(strict_types=1);

namespace Delivery\Contracts\Enum;

enum TarifCodeEnum: string
{
    case BASIC = 'basic';
    case PRO = 'pro';
    case ENTERPRISE = 'enterprise';
}

