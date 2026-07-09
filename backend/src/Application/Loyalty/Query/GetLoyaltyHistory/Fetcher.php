<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Query\GetLoyaltyHistory;

use App\Application\Loyalty\Entity\Account\LoyaltyAccountRepositoryInterface;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransaction;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionRepositoryInterface;

/**
 * История операций по бонусному кошельку гостя (начисления, списания, корректировки).
 */
class Fetcher
{
    public function __construct(
        private readonly LoyaltyAccountRepositoryInterface $accounts,
        private readonly LoyaltyTransactionRepositoryInterface $transactions,
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetch(Query $query): array
    {
        $account = $this->accounts->findByCustomer($query->workspaceId, $query->userId);

        if ($account === null) {
            return [];
        }

        return array_map(
            static fn(LoyaltyTransaction $transaction): array => [
                'type' => $transaction->type->value,
                'points' => $transaction->points,
                'balance_after' => $transaction->balanceAfter,
                'order_id' => $transaction->orderId,
                'comment' => $transaction->comment,
                'created_at' => $transaction->createdAt->format(\DateTimeInterface::ATOM),
            ],
            $this->transactions->findByAccount($account->id, max(1, min($query->limit, 200))),
        );
    }
}
