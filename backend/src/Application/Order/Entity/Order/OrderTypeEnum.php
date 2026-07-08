<?php

declare(strict_types=1);

namespace App\Application\Order\Entity\Order;

enum OrderTypeEnum: string
{
    case Delivery = 'delivery';
    case Pickup = 'pickup';
}
