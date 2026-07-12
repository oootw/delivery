<?php

declare(strict_types=1);

namespace App\Shared\Contract\Payment\OrderPaymentGateway;

/**
 * Резолвер платёжного шлюза заказа по воркспейсу: читает настройки воркспейса
 * (провайдер + креды) и возвращает готовый адаптер. Воркспейс без активной настройки —
 * платформенный CloudPayments (обратная совместимость).
 */
interface OrderPaymentGatewayResolverInterface
{
    public function forWorkspace(int $workspaceId): OrderPaymentGatewayInterface;
}
