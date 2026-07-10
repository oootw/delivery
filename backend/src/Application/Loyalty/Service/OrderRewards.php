<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Service;

use App\Application\Loyalty\Entity\Account\LoyaltyAccount;
use App\Application\Loyalty\Entity\Account\LoyaltyAccountRepositoryInterface;
use App\Application\Loyalty\Entity\Program\LoyaltyProgramRepositoryInterface;
use App\Application\Loyalty\Entity\Redemption\LoyaltyRedemption;
use App\Application\Loyalty\Entity\Redemption\LoyaltyRedemptionRepositoryInterface;
use App\Application\Loyalty\Entity\Stamp\StampProgramRepositoryInterface;
use App\Application\Loyalty\Entity\Stamp\StampProgressRepositoryInterface;
use App\Application\Loyalty\Entity\Tier\LoyaltyTierRepositoryInterface;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransaction;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionRepositoryInterface;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionTypeEnum;
use App\Application\Order\Rewards\OrderRewardsInterface;
use App\Application\Order\Rewards\RedeemQuoteRequest;
use App\Application\Order\Rewards\RedeemQuoteResult;
use App\Application\Order\Rewards\TierDiscount;

/**
 * Адаптер бонусной системы для заказа (реализует порт домена Order). Резервирует и
 * списывает баллы по жизненному циклу заказа, начисляет кэшбэк при завершении, ведёт
 * уровень гостя по сумме трат (кэшбэк с прибавкой уровня, постоянная скидка уровня) и
 * продвигает карту штампов (награда баллами при заполнении).
 */
class OrderRewards implements OrderRewardsInterface
{
    public function __construct(
        private readonly LoyaltyProgramRepositoryInterface $programs,
        private readonly LoyaltyAccountRepositoryInterface $accounts,
        private readonly LoyaltyRedemptionRepositoryInterface $redemptions,
        private readonly LoyaltyTransactionRepositoryInterface $transactions,
        private readonly LoyaltyTierRepositoryInterface $tiers,
        private readonly TierResolver $tierResolver,
        private readonly StampProgramRepositoryInterface $stampPrograms,
        private readonly StampProgressRepositoryInterface $stampProgress,
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

    public function releaseOnCancel(int $orderId, int $workspaceId, int $customerId, int $netPaidKopecks): void
    {
        $this->releaseRedemption($orderId);
        $this->reverseAccrual($orderId, $workspaceId, $customerId, $netPaidKopecks);
    }

    public function accrueOnCompleted(int $orderId, int $workspaceId, int $customerId, int $netPaidKopecks): int
    {
        // Идемпотентность: одно начисление на заказ. Главная гарантия — терминальность
        // статуса completed (повторный переход бросает исключение до этого вызова);
        // existsEarnForOrder дополнительно страхует кэшбэк от двойного начисления.
        if ($this->transactions->existsEarnForOrder($orderId)) {
            return 0;
        }

        $account = $this->accounts->getOrCreate($workspaceId, $customerId);

        // Траты и уровень копим независимо от программы кэшбэка (уровень растёт по сумме).
        $account->recordSpend($netPaidKopecks);
        $tier = $this->tierResolver->resolve($account->lifetimeSpentKopecks, $this->tiers->findByWorkspace($workspaceId));
        $account->setTier($tier?->id);

        // Кэшбэк — если программа настроена; ставка с прибавкой уровня.
        $earned = 0;
        $program = $this->programs->findByWorkspace($workspaceId);

        if ($program !== null) {
            $earned = $program->earnPointsFor($netPaidKopecks, $tier?->earnRateBonusBasisPoints ?? 0);
            $account->earn($earned);
        }

        $earnBalanceAfter = $account->pointsBalance;

        // Штампы — отдельный слой поверх; заполненная карта даёт баллы на кошелёк.
        $stampRewards = $this->advanceStamps($account, $workspaceId, $customerId);

        $this->accounts->save($account);

        if ($earned > 0) {
            $this->transactions->save(
                LoyaltyTransaction::buildNew(
                    accountId: $account->id,
                    workspaceId: $workspaceId,
                    orderId: $orderId,
                    type: LoyaltyTransactionTypeEnum::Earn,
                    points: $earned,
                    balanceAfter: $earnBalanceAfter,
                ),
            );
        }

        foreach ($stampRewards as $balanceAfter) {
            $this->transactions->save(
                LoyaltyTransaction::buildNew(
                    accountId: $account->id,
                    workspaceId: $workspaceId,
                    orderId: $orderId,
                    type: LoyaltyTransactionTypeEnum::StampReward,
                    points: $balanceAfter['points'],
                    balanceAfter: $balanceAfter['balance_after'],
                    comment: 'Награда за заполненную карту штампов',
                ),
            );
        }

        return $earned;
    }

    /**
     * Продвинуть карту штампов гостя на один штамп и выдать награду баллами при
     * заполнении (переполнение сверх порога остаётся на следующую карту). Начисление
     * идёт на переданный аккаунт (сохраняется вызывающим).
     *
     * @return list<array{points: int, balance_after: int}> выданные награды (для леджера)
     */
    private function advanceStamps(LoyaltyAccount $account, int $workspaceId, int $customerId): array
    {
        $program = $this->stampPrograms->findByWorkspace($workspaceId);

        if ($program === null || !$program->isEnabled) {
            return [];
        }

        $progress = $this->stampProgress->getOrCreate($workspaceId, $customerId);
        $progress->addStamp();

        $rewards = [];

        while ($progress->currentStamps >= $program->requiredCount) {
            $progress->redeemReward($program->requiredCount);
            $account->earn($program->rewardPoints);
            $rewards[] = ['points' => $program->rewardPoints, 'balance_after' => $account->pointsBalance];
        }

        $this->stampProgress->save($progress);

        return $rewards;
    }

    public function currentTierDiscount(int $workspaceId, int $customerId): TierDiscount
    {
        $account = $this->accounts->findByCustomer($workspaceId, $customerId);

        if ($account === null) {
            return TierDiscount::none();
        }

        $tier = $this->tierResolver->resolve($account->lifetimeSpentKopecks, $this->tiers->findByWorkspace($workspaceId));

        if ($tier === null) {
            return TierDiscount::none();
        }

        return new TierDiscount($tier->permanentDiscountBasisPoints, $tier->name);
    }

    private function releaseRedemption(int $orderId): void
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

    /**
     * Откат трат и уровня при отмене ранее завершённого заказа. Срабатывает только
     * если по заказу было начисление (existsEarnForOrder) — т.е. заказ был completed.
     * Сейчас недостижимо (статус completed финальный), но откат корректен, если
     * появится возврат/расзавершение заказа. Начисленные баллы не отзываем — как и
     * прежде при отмене оплаченного заказа кэшбэк остаётся у гостя.
     */
    private function reverseAccrual(int $orderId, int $workspaceId, int $customerId, int $netPaidKopecks): void
    {
        if (!$this->transactions->existsEarnForOrder($orderId)) {
            return;
        }

        $account = $this->accounts->findByCustomer($workspaceId, $customerId);

        if ($account === null) {
            return;
        }

        $account->reduceSpend($netPaidKopecks);

        $tier = $this->tierResolver->resolve($account->lifetimeSpentKopecks, $this->tiers->findByWorkspace($workspaceId));
        $account->setTier($tier?->id);

        $this->accounts->save($account);
    }
}
