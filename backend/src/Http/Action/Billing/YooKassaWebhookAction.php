<?php

declare(strict_types=1);

namespace App\Http\Action\Billing;

use App\Application\Order\Command\RecordOrderPayment\RecordOrderPaymentCommand;
use App\Application\Order\Command\RecordOrderPayment\RecordOrderPaymentHandler;
use App\Shared\Contract\Payment\OrderPaymentGateway\OrderPaymentStatusResolverInterface;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Приём webhook'ов ЮKassa об оплате заказов. У ЮKassa нет подписи webhook, поэтому
 * подлинность подтверждаем перезапросом платежа у API кредами воркспейса
 * (workspace_id из metadata): берём авторитетные статус и metadata.order_id, а не
 * доверяем телу уведомления. При succeeded проводим оплату заказа (идемпотентно).
 *
 * Ответ: 200 — обработано/нечего делать (ЮKassa не повторяет); 5xx — транзиентная
 * ошибка (недоступность API/БД), ЮKassa повторит доставку.
 */
class YooKassaWebhookAction extends AbstractController
{
    public function __construct(
        private readonly OrderPaymentStatusResolverInterface $paymentStatusResolver,
        private readonly RecordOrderPaymentHandler $recordOrderPayment,
    ) {}

    #[Route('/webhooks/yookassa', name: 'app_yookassa_webhook', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        try {
            $object = $request->toArray()['object'] ?? [];

            $paymentId = $object['id'] ?? null;
            $workspaceId = $object['metadata']['workspace_id'] ?? null;

            // Не наш платёж или нет данных для сопоставления — просто подтверждаем приём.
            if (!is_string($paymentId) || $workspaceId === null) {
                return new JsonResponse(['ok' => true]);
            }

            $status = $this->paymentStatusResolver->fetchStatus(
                workspaceId: (int) $workspaceId,
                externalPaymentId: $paymentId,
            );

            if ($status->isSucceeded && $status->orderId !== null) {
                $this->recordOrderPayment->handle(
                    new RecordOrderPaymentCommand(
                        invoiceId: null,
                        externalPaymentId: $paymentId,
                        paidAt: new \DateTimeImmutable(),
                        orderId: $status->orderId,
                    ),
                );
            }

            return new JsonResponse(['ok' => true]);
        } catch (\DomainException $exception) {
            // Бизнес-исход (не наш воркспейс/заказ) — повтор не поможет, подтверждаем приём.
            LoggerService::toFile(
                fileName: 'billing/yookassa-webhook',
                message: $exception->getMessage(),
            );

            return new JsonResponse(['ok' => true]);
        } catch (\Throwable $exception) {
            // Транзиентная ошибка (API/БД недоступны) — просим ЮKassa повторить.
            LoggerService::toFile(
                fileName: 'billing/yookassa-webhook',
                message: $exception->getMessage(),
            );

            return new JsonResponse(['ok' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
