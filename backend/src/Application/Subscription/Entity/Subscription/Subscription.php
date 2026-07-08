<?php

declare(strict_types=1);

namespace App\Application\Subscription\Entity\Subscription;

use App\Application\Tarif\Entity\Tarif\TarifCodeEnum;

/**
 * Подписка владельца на тариф.
 *
 * Право владельца в системе = наличие активной подписки (см. isActive()).
 * Оплата рекуррентная: первый платёж активирует подписку, каждое успешное
 * списание продлевает период, неудачное — переводит в past_due.
 */
class Subscription
{
    private const PERIOD_LENGTH = '+1 month';

    public function __construct(
        public ?int $id,
        public int $userId,
        public TarifCodeEnum $tarifCode,
        public SubscriptionStatusEnum $status,
        /** Идентификатор счёта, который мы передаём в CloudPayments (InvoiceId). */
        public string $invoiceId,
        /** Идентификатор подписки на стороне CloudPayments, появляется после первого платежа. */
        public ?string $externalId,
        public ?\DateTimeImmutable $currentPeriodEnd,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(int $userId, TarifCodeEnum $tarifCode, string $invoiceId): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            userId: $userId,
            tarifCode: $tarifCode,
            status: SubscriptionStatusEnum::Pending,
            invoiceId: $invoiceId,
            externalId: null,
            currentPeriodEnd: null,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    /** Успешный платёж: активирует подписку и продлевает оплаченный период на месяц вперёд. */
    public function registerPayment(?string $externalId, \DateTimeImmutable $paidAt): void
    {
        if ($externalId !== null) {
            $this->externalId = $externalId;
        }

        $this->status = SubscriptionStatusEnum::Active;
        $this->currentPeriodEnd = $paidAt->modify(self::PERIOD_LENGTH);
        $this->touch();
    }

    public function markPastDue(): void
    {
        $this->status = SubscriptionStatusEnum::PastDue;
        $this->touch();
    }

    public function cancel(): void
    {
        $this->status = SubscriptionStatusEnum::Canceled;
        $this->touch();
    }

    public function isActive(): bool
    {
        return $this->status === SubscriptionStatusEnum::Active;
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }

    private function touch(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
