<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Service;

use App\Application\Loyalty\Entity\Account\LoyaltyAccountRepositoryInterface;
use App\Application\Loyalty\Entity\Program\LoyaltyProgramRepositoryInterface;
use App\Application\Loyalty\Entity\Redemption\LoyaltyRedemption;
use App\Application\Loyalty\Entity\Redemption\LoyaltyRedemptionRepositoryInterface;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransaction;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionRepositoryInterface;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionTypeEnum;
use App\Application\Order\Rewards\OrderRewardsInterface;
use App\Application\Order\Rewards\RedeemQuoteRequest;
use App\Application\Order\Rewards\RedeemQuoteResult;

/**
 * Адаптер бонусной системы для заказа (реализует порт домена Order). Резервирует и
 * списывает баллы по жизненному циклу заказа и начисляет кэшбэк при завершении.
 */
class OrderRewards implements OrderRewardsInterface
{
    public function __construct(
        private readonly LoyaltyProgramRepositoryInterface $programs,
        private readonly LoyaltyAccountRepositoryInterface $accounts,
        private readonly LoyaltyRedemptionRepositoryInterface $redemptions,
        private readonly LoyaltyTransactionRepositoryInterface $transactions,
    ) {}

    public function quoteRedeem(RedeemQuoteRequest $request): RedeemQuoteResult
    {
        if ($request->pointsToSpend <= 0) {
            return new RedeemQuoteResult(0, 0);
        }

        $program = $this->programs->findByWorkspace($request->workspaceId);

        if ($program === null) {
            return new RedeemQuoteResult(0, 0);
        }

        $account = $this->accounts->findByCustomer($request->workspaceId, $request->customerId);
        $available = $account?->availablePoints() ?? 0;

        $pointsSpent = $program->redeemablePoints($request->pointsToSpend, $available, $request->maxBaseKopecks);

        return new RedeemQuoteResult($pointsSpent, $pointsSpent * $program->pointValueKopecks);
    }

    public function reserveOnPlace(int $orderId, RedeemQuoteRequest $request, RedeemQuoteResult $result): void
    {
        if ($result->pointsSpent <= 0) {
            return;
        }

        $account = $this->accounts->getOrCreate($request->workspaceId, $request->customerId);
        $account->reserve($result->pointsSpent);
        $this->accounts->save($account);

        $this->redemptions->save(
            LoyaltyRedemption::buildNew(
                workspaceId: $request->workspaceId,
                accountId: $account->id,
                orderId: $orderId,
                customerId: $request->customerId,
                points: $result->pointsSpent,
            ),
        );
    }

    public function finalizeOnPaid(int $orderId): void
    {
        $redemption = $this->redemptions->findByOrder($orderId);

        if ($redemption === null || !$redemption->isReserved()) {
            return;
        }

        $account = $this->accounts->findByCustomer($redemption->workspaceId, $redemption->customerId);

        if ($account === null) {
            return;
        }

        $account->finalizeReserve($redemption->points);
        $this->accounts->save($account);

        $redemption->finalize();
        $this->redemptions->save($redemption);

        $this->transactions->save(
            LoyaltyTransaction::buildNew(
                accountId: $account->id,
                workspaceId: $redemption->workspaceId,
                orderId: $orderId,
                type: LoyaltyTransactionTypeEnum::RedeemFinalize,
                points: -$redemption->points,
                balanceAfter: $account->pointsBalance,
            ),
        );
    }

    public function releaseOnCancel(int $orderId): void
    {
        $redemption = $this->redemptions->findByOrder($orderId);

        if ($redemption === null) {
            return;
        }

        $account = $this->accounts->findByCustomer($redemption->workspaceId, $redemption->customerId);

        if ($account === null) {
            return;
        }

        if ($redemption->isReserved()) {
            $account->releaseReserve($redemption->points);
            $this->accounts->save($account);
            $redemption->release();
            $this->redemptions->save($redemption);

            return;
        }

        if ($redemption->isFinalized()) {
            $account->refund($redemption->points);
            $this->accounts->save($account);
            $redemption->refund();
            $this->redemptions->save($redemption);

            $this->transactions->save(
                LoyaltyTransaction::buildNew(
                    accountId: $account->id,
                    workspaceId: $redemption->workspaceId,
                    orderId: $orderId,
                    type: LoyaltyTransactionTypeEnum::Refund,
                    points: $redemption->points,
                    balanceAfter: $account->pointsBalance,
                ),
            );
        }
    }

    public function accrueOnCompleted(int $orderId, int $workspaceId, int $customerId, int $netPaidKopecks): int
    {
        $program = $this->programs->findByWorkspace($workspaceId);

        if ($program === null) {
            return 0;
        }

        if ($this->transactions->existsEarnForOrder($orderId)) {
            return 0;
        }

        $earned = $program->earnPointsFor($netPaidKopecks);

        if ($earned <= 0) {
            return 0;
        }

        $account = $this->accounts->getOrCreate($workspaceId, $customerId);
        $account->earn($earned);
        $this->accounts->save($account);

        $this->transactions->save(
            LoyaltyTransaction::buildNew(
                accountId: $account->id,
                workspaceId: $workspaceId,
                orderId: $orderId,
                type: LoyaltyTransactionTypeEnum::Earn,
                points: $earned,
                balanceAfter: $account->pointsBalance,
            ),
        );

        return $earned;
    }
}
