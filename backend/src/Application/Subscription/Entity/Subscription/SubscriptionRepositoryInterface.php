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

    public function findLatestByUser(int $userId): ?Subscription;
}
