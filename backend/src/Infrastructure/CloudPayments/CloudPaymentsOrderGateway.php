<?php

declare(strict_types=1);

namespace App\Infrastructure\CloudPayments;

use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentGatewayInterface;
use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentInstruction;
use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentRequest;
use App\Shared\Contract\Payment\PaymentProviderEnum;

/**
 * Адаптер оплаты заказа через CloudPayments. Первый платёж инициирует виджет на фронте,
 * поэтому сервер не ходит в API — только отдаёт параметры виджета. Оплату подтверждает
 * webhook /pay (маркер Data.kind = order). publicId — платформенный (фолбэк) либо владельца.
 * Экземпляр собирает WorkspaceOrderPaymentGatewayFactory с нужным publicId.
 */
final class CloudPaymentsOrderGateway implements OrderPaymentGatewayInterface
{
    public function __construct(
        private readonly string $publicId,
    ) {}

    public function createPayment(OrderPaymentRequest $request): OrderPaymentInstruction
    {
        return new OrderPaymentInstruction(
            provider: PaymentProviderEnum::CloudPayments,
            confirmationType: 'widget',
            payload: [
                'public_id' => $this->publicId,
                'invoice_id' => $request->invoiceId,
                'account_id' => $request->customerId,
                'amount' => $request->amountAsString(),
                'currency' => $request->currency,
                'description' => $request->description,
                'data' => ['kind' => 'order'],
            ],
        );
    }
}
