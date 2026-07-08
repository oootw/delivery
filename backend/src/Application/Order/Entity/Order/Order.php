<?php

declare(strict_types=1);

namespace App\Application\Order\Entity\Order;

/**
 * Заказ гостя в точке. Оформляется авторизованным пользователем, оплачивается
 * онлайн через CloudPayments (первый платёж — виджетом на фронте, подтверждение —
 * webhook'ом). Позиции и суммы фиксируются на момент оформления.
 *
 * Переходы статусов описаны явной картой (allowedNextStatuses) и читаются линейно:
 * created → paid → accepted → cooking → ready → on_the_way → completed,
 * из любого не финального статуса возможна отмена. on_the_way только для доставки,
 * самовывоз завершается сразу из ready.
 */
class Order
{
    /**
     * @param OrderItem[] $items
     * @param list<array{status: string, source: string, at: string}> $history
     */
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public int $venueId,
        public int $customerId,
        public OrderTypeEnum $type,
        public OrderStatusEnum $status,
        public array $items,
        public int $totalKopecks,
        public string $contactName,
        public string $contactPhone,
        public ?string $deliveryAddress,
        public ?string $comment,
        public string $invoiceId,
        public ?string $externalPaymentId,
        public ?int $estimatedWaitMinutes,
        public array $history,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    /**
     * @param OrderItem[] $items
     */
    public static function buildNew(
        int $workspaceId,
        int $venueId,
        int $customerId,
        OrderTypeEnum $type,
        array $items,
        int $totalKopecks,
        string $contactName,
        string $contactPhone,
        ?string $deliveryAddress,
        ?string $comment,
        string $invoiceId,
    ): self {
        $now = new \DateTimeImmutable();

        $order = new self(
            id: null,
            workspaceId: $workspaceId,
            venueId: $venueId,
            customerId: $customerId,
            type: $type,
            status: OrderStatusEnum::Created,
            items: $items,
            totalKopecks: $totalKopecks,
            contactName: $contactName,
            contactPhone: $contactPhone,
            deliveryAddress: $deliveryAddress,
            comment: $comment,
            invoiceId: $invoiceId,
            externalPaymentId: null,
            estimatedWaitMinutes: null,
            history: [],
            createdAt: $now,
            updatedAt: $now,
        );

        $order->recordTransition(OrderStatusEnum::Created, OrderStatusSourceEnum::Customer, $now);

        return $order;
    }

    /** Подтверждённая онлайн-оплата: заказ становится виден точке. */
    public function registerPayment(?string $externalPaymentId, \DateTimeImmutable $paidAt): void
    {
        if ($this->status !== OrderStatusEnum::Created) {
            throw new \DomainException('Оплата возможна только для нового заказа');
        }

        $this->externalPaymentId = $externalPaymentId;
        $this->moveTo(OrderStatusEnum::Paid, OrderStatusSourceEnum::System, $paidAt);
    }

    public function changeStatus(OrderStatusEnum $newStatus, OrderStatusSourceEnum $source): void
    {
        if (!in_array($newStatus, $this->allowedNextStatuses(), true)) {
            throw new \DomainException(
                sprintf('Нельзя перевести заказ из «%s» в «%s»', $this->status->value, $newStatus->value),
            );
        }

        $this->moveTo($newStatus, $source, new \DateTimeImmutable());
    }

    public function cancel(OrderStatusSourceEnum $source): void
    {
        $this->changeStatus(OrderStatusEnum::Canceled, $source);
    }

    public function applyWaitEstimate(int $minutes): void
    {
        $this->estimatedWaitMinutes = $minutes;
        $this->touch();
    }

    /**
     * @return OrderStatusEnum[]
     */
    public function allowedNextStatuses(): array
    {
        return match ($this->status) {
            OrderStatusEnum::Created => [OrderStatusEnum::Paid, OrderStatusEnum::Canceled],
            OrderStatusEnum::Paid => [OrderStatusEnum::Accepted, OrderStatusEnum::Canceled],
            OrderStatusEnum::Accepted => [OrderStatusEnum::Cooking, OrderStatusEnum::Canceled],
            OrderStatusEnum::Cooking => [OrderStatusEnum::Ready, OrderStatusEnum::Canceled],
            OrderStatusEnum::Ready => $this->type === OrderTypeEnum::Delivery
                ? [OrderStatusEnum::OnTheWay, OrderStatusEnum::Canceled]
                : [OrderStatusEnum::Completed, OrderStatusEnum::Canceled],
            OrderStatusEnum::OnTheWay => [OrderStatusEnum::Completed, OrderStatusEnum::Canceled],
            OrderStatusEnum::Completed, OrderStatusEnum::Canceled => [],
        };
    }

    /** Сумма количеств всех позиций — «единицы» блюд, мера трудоёмкости заказа. */
    public function unitCount(): int
    {
        $units = 0;

        foreach ($this->items as $item) {
            $units += $item->quantity;
        }

        return $units;
    }

    /** Момент первого перехода в указанный статус по истории, если он был. */
    public function enteredStatusAt(OrderStatusEnum $status): ?\DateTimeImmutable
    {
        foreach ($this->history as $transition) {
            if ($transition['status'] === $status->value) {
                return new \DateTimeImmutable($transition['at']);
            }
        }

        return null;
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }

    private function moveTo(OrderStatusEnum $newStatus, OrderStatusSourceEnum $source, \DateTimeImmutable $at): void
    {
        $this->status = $newStatus;
        $this->recordTransition($newStatus, $source, $at);
        $this->updatedAt = $at;
    }

    private function recordTransition(OrderStatusEnum $status, OrderStatusSourceEnum $source, \DateTimeImmutable $at): void
    {
        $this->history[] = [
            'status' => $status->value,
            'source' => $source->value,
            'at' => $at->format(\DateTimeInterface::ATOM),
        ];
    }

    private function touch(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
