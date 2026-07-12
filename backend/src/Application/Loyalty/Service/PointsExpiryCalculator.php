<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Service;

use App\Application\Loyalty\Entity\Transaction\LoyaltyTransaction;

/**
 * Чистый расчёт сгорающих баллов по методу FIFO: баллы тратятся в порядке начисления
 * (старые — первыми), поэтому сгорают только те начисления, что дожили до cutoff
 * непотраченными. Прошлые списания и предыдущие сгорания в леджере (отрицательные
 * записи) «съедают» самые старые начисления, что обеспечивает идемпотентность между
 * запусками крона.
 */
final class PointsExpiryCalculator
{
    /**
     * @param LoyaltyTransaction[] $ledgerAscending весь леджер кошелька по возрастанию времени
     * @return int сколько баллов сгорело (начислены раньше cutoff и ещё не потрачены)
     */
    public function expiredPoints(array $ledgerAscending, \DateTimeImmutable $cutoff): int
    {
        /** @var array<int, array{at: \DateTimeImmutable, remaining: int}> $lots */
        $lots = [];

        foreach ($ledgerAscending as $transaction) {
            if ($transaction->points > 0) {
                $lots[] = ['at' => $transaction->createdAt, 'remaining' => $transaction->points];

                continue;
            }

            $this->consumeOldest($lots, -$transaction->points);
        }

        $expired = 0;

        foreach ($lots as $lot) {
            if ($lot['remaining'] > 0 && $lot['at'] < $cutoff) {
                $expired += $lot['remaining'];
            }
        }

        return $expired;
    }

    /**
     * @param array<int, array{at: \DateTimeImmutable, remaining: int}> $lots
     */
    private function consumeOldest(array &$lots, int $amount): void
    {
        foreach ($lots as $index => $lot) {
            if ($amount <= 0) {
                return;
            }

            $consumed = min($amount, $lot['remaining']);
            $lots[$index]['remaining'] -= $consumed;
            $amount -= $consumed;
        }
    }
}
