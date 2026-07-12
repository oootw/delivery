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
        /** TransactionId последнего успешного платежа — для дедупликации повторной доставки webhook'а. */
        public ?string $lastPaymentTransactionId = null,
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

    /**
     * Успешный платёж: активирует подписку и продлевает оплаченный период на месяц вперёд.
     * Повторная доставка того же платежа (одинаковый transactionId) игнорируется, чтобы
     * не продлевать период дважды. Возвращает true, если платёж применён (новый).
     */
    public function registerPayment(?string $externalId, \DateTimeImmutable $paidAt, ?string $transactionId = null): bool
    {
        if ($transactionId !== null && $transactionId === $this->lastPaymentTransactionId) {
            return false;
        }

        if ($externalId !== null) {
            $this->externalId = $externalId;
        }

        if ($transactionId !== null) {
            $this->lastPaymentTransactionId = $transactionId;
        }

        $this->status = SubscriptionStatusEnum::Active;
        $this->currentPeriodEnd = $paidAt->modify(self::PERIOD_LENGTH);
        $this->touch();

        return true;
    }

    /** Сменить тариф у ещё не оплаченной подписки (гость передумал до оплаты). */
    public function changePendingTarif(TarifCodeEnum $tarifCode): void
    {
        if ($this->status !== SubscriptionStatusEnum::Pending) {
            throw new \DomainException('Сменить тариф можно только у неоплаченной подписки');
        }

        $this->tarifCode = $tarifCode;
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
