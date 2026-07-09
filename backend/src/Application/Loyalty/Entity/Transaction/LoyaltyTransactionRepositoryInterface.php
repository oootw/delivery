<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Transaction;

interface LoyaltyTransactionRepositoryInterface
{
    public function save(LoyaltyTransaction $transaction): void;

    /**
     * Недавние операции по кошельку (для истории гостя), новые первыми.
     *
     * @return LoyaltyTransaction[]
     */
    public function findByAccount(int $accountId, int $limit): array;

    /** Начислялся ли уже кэшбэк за заказ — защита от повторного начисления. */
    public function existsEarnForOrder(int $orderId): bool;
}
