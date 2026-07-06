<?php

declare(strict_types=1);

namespace App\Shared\Enum\Feature;

enum FeatureCodeEnum: string
{
    case POINTS = 'points';
    case CRM = 'crm';
    case ANALYTICS = 'analytics';
    case SUPPORT = 'support';
    case CUSTOMIZATION = 'customization';
}
