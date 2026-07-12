<?php

declare(strict_types=1);

namespace App\Shared\Contract\Payment\OrderPaymentGateway;

/**
 * Авторитетный статус платежа, полученный перезапросом у провайдера (не из тела webhook,
 * которое можно подделать). orderId берётся из metadata платежа на стороне провайдера.
 */
final class OrderPaymentStatus
{
    public function __construct(
        public readonly bool $isSucceeded,
        public readonly ?int $orderId,
        public readonly int $amountKopecks,
    ) {}
}
