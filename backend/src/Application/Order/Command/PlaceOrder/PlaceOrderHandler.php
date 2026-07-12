<?php

declare(strict_types=1);

namespace App\Application\Order\Command\PlaceOrder;

use App\Application\Order\Entity\Order\Order;
use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Entity\Order\OrderTypeEnum;
use App\Application\Order\Pricing\OrderPriceCalculator;
use App\Application\Order\Pricing\OrderPricingInterface;
use App\Application\Order\Realtime\OrderRealtimeNotifierInterface;
use App\Application\Order\Rewards\OrderRewardsInterface;
use App\Application\Order\WaitTime\WaitTimeRecalculatorInterface;
use App\Application\Workspace\Service\WorkspaceAccess;
use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentGatewayResolverInterface;
use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentRequest;
use App\Shared\Transaction\TransactionInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Оформление заказа. Цена считается общим калькулятором (тем же, что и предпросмотр):
 * позиции берутся из актуального меню точки и фиксируются в заказе. Заказ создаётся
 * в статусе «created» и ждёт онлайн-оплаты — платёжные реквизиты возвращаются виджету.
 * Заказ с нулевым итогом (всё покрыто баллами или 100% промо) провести онлайн нельзя,
 * поэтому он сразу оплачивается на сервере в той же транзакции.
 */
class PlaceOrderHandler
{
    private const CURRENCY = 'RUB';

    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly OrderPricingInterface $orderPricing,
        private readonly OrderRewardsInterface $orderRewards,
        private readonly OrderPriceCalculator $priceCalculator,
        private readonly TransactionInterface $transaction,
        private readonly OrderRealtimeNotifierInterface $realtimeNotifier,
        private readonly WaitTimeRecalculatorInterface $waitTimeRecalculator,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly OrderPaymentGatewayResolverInterface $orderPaymentGateways,
    ) {}

    public function handle(PlaceOrderCommand $command): PlacedOrderDTO
    {
        $breakdown = $this->priceCalculator->calculate(
            venueId: $command->venueId,
            customerId: $command->customerId,
            type: $command->type,
            cartLines: $command->lines,
            promocode: $command->promocode,
            pointsToSpend: $command->pointsToSpend,
            comboLines: $command->comboLines,
            requireVenueOpen: true,
        );

        // Воркспейс с неоплаченной подпиской заказы не принимает (витрина «гаснет»).
        $this->workspaceAccess->requireActiveWorkspace($breakdown->workspaceId);

        $type = $breakdown->type;
        $deliveryAddress = $command->deliveryAddress;

        if ($type === OrderTypeEnum::Delivery && ($deliveryAddress === null || trim($deliveryAddress) === '')) {
            throw new \DomainException('Укажите адрес доставки');
        }

        if ($type === OrderTypeEnum::Pickup) {
            $deliveryAddress = null;
        }

        $order = Order::buildNew(
            workspaceId: $breakdown->workspaceId,
            venueId: $breakdown->venueId,
            customerId: $command->customerId,
            type: $type,
            items: $breakdown->orderItems,
            subtotalKopecks: $breakdown->subtotalKopecks,
            discountKopecks: $breakdown->discountKopecks,
            appliedDiscounts: $breakdown->appliedDiscounts,
            pointsSpent: $breakdown->pointsSpent,
            pointsDiscountKopecks: $breakdown->pointsDiscountKopecks,
            contactName: $command->contactName,
            contactPhone: $command->contactPhone,
            deliveryAddress: $deliveryAddress,
            comment: $command->comment,
            invoiceId: Uuid::v4()->toRfc4122(),
        );

        $isFree = $breakdown->payableKopecks === 0;

        // Заказ, запись применённых скидок и резерв баллов — атомарно: либо всё, либо ничего.
        // Для бесплатного заказа тут же проводим оплату на сервере (списываем резерв баллов),
        // иначе онлайн-оплаты не будет и заказ навсегда останется в «created».
        $orderId = $this->transaction->wrap(function () use ($order, $breakdown, $isFree): int {
            $orderId = $this->orders->save($order);

            // Скидка применилась — фиксируем в леджере и счётчиках лимитов.
            $this->orderPricing->recordApplied($orderId, $breakdown->pricingRequest, $breakdown->pricingResult);

            // Резервируем списываемые баллы под заказ (спишутся при оплате).
            $this->orderRewards->reserveOnPlace($orderId, $breakdown->redeemRequest, $breakdown->redeemResult);

            if ($isFree) {
                $order->registerPayment(externalPaymentId: null, paidAt: new \DateTimeImmutable());
                $this->orders->save($order);
                $this->orderRewards->finalizeOnPaid($orderId);
            }

            return $orderId;
        });

        if ($isFree) {
            // Побочные эффекты оплаты — после коммита (как в RecordOrderPayment).
            $this->realtimeNotifier->publishStatus($order);
            $this->waitTimeRecalculator->recalculateForVenue($order->venueId);

            return new PlacedOrderDTO(orderId: $orderId, paymentRequired: false, paymentInstruction: null);
        }

        // Инициируем оплату шлюзом воркспейса ПОСЛЕ коммита заказа (внешний вызов вне
        // транзакции). Если провайдер недоступен — заказ остаётся в «created» и будет
        // отменён кроном брошенных заказов с возвратом резервов баллов.
        $paymentInstruction = $this->orderPaymentGateways
            ->forWorkspace($breakdown->workspaceId)
            ->createPayment(
                new OrderPaymentRequest(
                    workspaceId: $breakdown->workspaceId,
                    orderId: $orderId,
                    invoiceId: $order->invoiceId,
                    customerId: $command->customerId,
                    amountKopecks: $breakdown->payableKopecks,
                    currency: self::CURRENCY,
                    description: 'Оплата заказа №' . $orderId,
                ),
            );

        return new PlacedOrderDTO(
            orderId: $orderId,
            paymentRequired: true,
            paymentInstruction: $paymentInstruction,
        );
    }
}
