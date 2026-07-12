<?php

declare(strict_types=1);

namespace App\Application\Subscription\Entity\Subscription;

interface SubscriptionRepositoryInterface
{
    public function save(Subscription $subscription): int;

    public function findById(int $id): ?Subscription;

    public function findByInvoiceId(string $invoiceId): ?Subscription;

    public function findByExternalId(string $externalId): ?Subscription;

    public function findActiveByUser(int $userId): ?Subscription;

    /** Незавершённая (ожидающая первой оплаты) подписка пользователя, если есть. */
    public function findPendingByUser(int $userId): ?Subscription;

    public function findLatestByUser(int $userId): ?Subscription;

    /**
     * Подписки в статусе past_due, попавшие в него раньше $updatedBefore — для
     * догоняющей крон-отмены (страховка на случай пропущенного терминального webhook).
     *
     * @return Subscription[]
     */
    public function findPastDueOlderThan(\DateTimeImmutable $updatedBefore): array;
}
