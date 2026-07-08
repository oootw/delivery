<?php

declare(strict_types=1);

namespace App\Application\Order\Entity\Order;

/**
 * Кто инициировал смену статуса заказа. Нужен для аудита и для того, чтобы
 * различать ручное управление персоналом и автоматическую синхронизацию из POS.
 */
enum OrderStatusSourceEnum: string
{
    case Customer = 'customer';
    case Staff = 'staff';
    case Pos = 'pos';
    case System = 'system';
}
