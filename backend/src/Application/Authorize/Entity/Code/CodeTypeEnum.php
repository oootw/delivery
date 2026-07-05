<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\Code;

enum CodeTypeEnum: string
{
    case Register = 'register';
    case Authorize = 'authorize';
}
