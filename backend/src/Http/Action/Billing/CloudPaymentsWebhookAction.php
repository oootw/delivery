<?php

declare(strict_types=1);

namespace App\Http\Action\Billing;

use App\Shared\Contract\Payment\PaymentGateway\PaymentGatewayInterface;
use App\Application\Order\Command\RecordOrderPayment\RecordOrderPaymentCommand;
use App\Application\Order\Command\RecordOrderPayment\RecordOrderPaymentHandler;
use App\Application\Subscription\Command\MarkSubscriptionPastDue\MarkSubscriptionPastDueCommand as MarkPastDueCommand;
use App\Application\Subscription\Command\MarkSubscriptionPastDue\MarkSubscriptionPastDueHandler as MarkPastDueHandler;
use App\Application\Subscription\Command\RecordSubscriptionPayment\RecordSubscriptionPaymentCommand as RecordPaymentCommand;
use App\Application\Subscription\Command\RecordSubscriptionPayment\RecordSubscriptionPaymentHandler as RecordPaymentHandler;
use App\Application\Subscription\Command\StopSubscription\StopSubscriptionCommand;
use App\Application\Subscription\Command\StopSubscription\StopSubscriptionHandler;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Приём webhook'ов CloudPayments. Каждый тип нотификации настраивается в кабинете
 * CloudPayments на отдельный путь: /pay, /fail, /recurrent.
 *
 * CloudPayments ожидает ответ {"code": 0} как подтверждение обработки; иначе
 * повторяет доставку. Поэтому на бизнес-ошибках отвечаем кодом 13 (отклонено),
 * а неверная подпись — 403.
 */
class CloudPaymentsWebhookAction extends AbstractController
{
    private const SIGNATURE_HEADER = 'Content-HMAC';

    /** Терминальные статусы рекуррента, означающие прекращение подписки. */
    private const TERMINAL_RECURRENT_STATUSES = ['Cancelled', 'Rejected', 'Expired', 'Finished'];

    public function __construct(
        private readonly PaymentGatewayInterface $paymentGateway,
        private readonly RecordPaymentHandler $recordPayment,
        private readonly RecordOrderPaymentHandler $recordOrderPayment,
        private readonly MarkPastDueHandler $markPastDue,
        private readonly StopSubscriptionHandler $stopSubscription,
    ) {}

    #[Route('/webhooks/cloudpayments/{type}', name: 'app_cloudpayments_webhook', methods: ['POST'])]
    public function handle(Request $request, string $type): Response
    {
        $signatureValid = $this->paymentGateway->verifyWebhookSignature(
            rawBody: $request->getContent(),
            signature: $request->headers->get(self::SIGNATURE_HEADER),
        );

        if (!$signatureValid) {
            return new JsonResponse(['code' => 13], Response::HTTP_FORBIDDEN);
        }

        try {
            $this->route($type, $request->request->all());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'billing/cloudpayments-webhook',
                message: $type . ': ' . $exception->getMessage(),
            );

            return new JsonResponse(['code' => 13]);
        }

        return new JsonResponse(['code' => 0]);
    }

    private function route(string $type, array $payload): void
    {
        match ($type) {
            'pay' => $this->handlePay($payload),
            'fail' => $this->handleFail($payload),
            'recurrent' => $this->handleRecurrent($payload),
            default => throw new \DomainException('Неизвестный тип webhook: ' . $type),
        };
    }

    /**
     * Оплата приходит на один и тот же путь и для подписок, и для заказов.
     * Различаем их по маркеру kind, который виджет кладёт в поле Data при оплате
     * заказа. Без маркера считаем платёж подпиской (обратная совместимость).
     */
    private function handlePay(array $payload): void
    {
        $paidAt = $this->readDateTime($payload['DateTime'] ?? null);

        if ($this->readPaymentKind($payload) === 'order') {
            $this->recordOrderPayment->handle(
                new RecordOrderPaymentCommand(
                    invoiceId: $payload['InvoiceId'] ?? null,
                    externalPaymentId: isset($payload['TransactionId']) ? (string) $payload['TransactionId'] : null,
                    paidAt: $paidAt,
                ),
            );

            return;
        }

        $this->recordPayment->handle(
            new RecordPaymentCommand(
                invoiceId: $payload['InvoiceId'] ?? null,
                externalId: $payload['SubscriptionId'] ?? null,
                paidAt: $paidAt,
                transactionId: isset($payload['TransactionId']) ? (string) $payload['TransactionId'] : null,
            ),
        );
    }

    private function readPaymentKind(array $payload): ?string
    {
        $rawData = $payload['Data'] ?? null;

        if (!is_string($rawData) || $rawData === '') {
            return null;
        }

        $data = json_decode($rawData, true);

        return is_array($data) && isset($data['kind']) ? (string) $data['kind'] : null;
    }

    private function handleFail(array $payload): void
    {
        $externalId = $payload['SubscriptionId'] ?? null;

        if ($externalId === null) {
            return;
        }

        $this->markPastDue->handle(new MarkPastDueCommand(externalId: $externalId));
    }

    private function handleRecurrent(array $payload): void
    {
        $externalId = $payload['Id'] ?? null;
        $status = $payload['Status'] ?? '';

        if ($externalId === null) {
            return;
        }

        if ($status === 'PastDue') {
            $this->markPastDue->handle(new MarkPastDueCommand(externalId: $externalId));

            return;
        }

        if (in_array($status, self::TERMINAL_RECURRENT_STATUSES, true)) {
            $this->stopSubscription->handle(new StopSubscriptionCommand(externalId: $externalId));
        }
    }

    private function readDateTime(?string $value): \DateTimeImmutable
    {
        if ($value === null || $value === '') {
            return new \DateTimeImmutable();
        }

        return new \DateTimeImmutable($value);
    }
}
