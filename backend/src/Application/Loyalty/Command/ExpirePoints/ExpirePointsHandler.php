<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Command\ExpirePoints;

use App\Application\Loyalty\Entity\Account\LoyaltyAccountRepositoryInterface;
use App\Application\Loyalty\Entity\Program\LoyaltyProgram;
use App\Application\Loyalty\Entity\Program\LoyaltyProgramRepositoryInterface;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransaction;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionRepositoryInterface;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionTypeEnum;
use App\Application\Loyalty\Service\PointsExpiryCalculator;
use App\Shared\Transaction\TransactionInterface;

/**
 * Сжигает баллы, начисленные раньше срока жизни (pointsLifetimeDays) и не потраченные.
 * Проходит по включённым программам с экспирацией → кошелькам с балансом → считает
 * сгорание FIFO по леджеру. Возвращает суммарно сгоревшие баллы.
 */
class ExpirePointsHandler
{
    public function __construct(
        private readonly LoyaltyProgramRepositoryInterface $programs,
        private readonly LoyaltyAccountRepositoryInterface $accounts,
        private readonly LoyaltyTransactionRepositoryInterface $transactions,
        private readonly PointsExpiryCalculator $expiryCalculator,
        private readonly TransactionInterface $transaction,
    ) {}

    public function handle(ExpirePointsCommand $command): int
    {
        $totalExpired = 0;

        foreach ($this->programs->findAllWithExpiry() as $program) {
            $totalExpired += $this->expireForProgram($program);
        }

        return $totalExpired;
    }

    private function expireForProgram(LoyaltyProgram $program): int
    {
        $cutoff = (new \DateTimeImmutable())->modify(sprintf('-%d days', $program->pointsLifetimeDays));
        $expiredInProgram = 0;

        foreach ($this->accounts->findByWorkspaceWithPoints($program->workspaceId) as $account) {
            $ledger = $this->transactions->findAllByAccountAsc($account->id);
            $expired = $this->expiryCalculator->expiredPoints($ledger, $cutoff);

            if ($expired <= 0) {
                continue;
            }

            $expiredInProgram += $this->burn($program->workspaceId, $account->customerId, $expired);
        }

        return $expiredInProgram;
    }

    private function burn(int $workspaceId, int $customerId, int $expired): int
    {
        return $this->transaction->wrap(function () use ($workspaceId, $customerId, $expired): int {
            // Перечитываем кошелёк под блокировкой: save() мапит и reservedPoints, поэтому
            // мутируем свежую строку, чтобы не затереть параллельный резерв под заказ.
            $account = $this->accounts->getOrCreateForUpdate($workspaceId, $customerId);
            $toBurn = min($expired, $account->availablePoints());

            if ($toBurn <= 0) {
                return 0;
            }

            $account->expire($toBurn);
            $this->accounts->save($account);

            $this->transactions->save(
                LoyaltyTransaction::buildNew(
                    accountId: $account->id,
                    workspaceId: $workspaceId,
                    orderId: null,
                    type: LoyaltyTransactionTypeEnum::Expire,
                    points: -$toBurn,
                    balanceAfter: $account->pointsBalance,
                    comment: 'Сгорание баллов по сроку жизни',
                ),
            );

            return $toBurn;
        });
    }
}
