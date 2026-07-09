<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Command\AdjustLoyaltyBalance;

use App\Application\Loyalty\Entity\Account\LoyaltyAccountRepositoryInterface;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransaction;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionRepositoryInterface;
use App\Application\Loyalty\Entity\Transaction\LoyaltyTransactionTypeEnum;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Ручная корректировка баланса баллов гостя владельцем (компенсации, поддержка).
 */
class Handler
{
    public function __construct(
        private readonly LoyaltyAccountRepositoryInterface $accounts,
        private readonly LoyaltyTransactionRepositoryInterface $transactions,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(Command $command): void
    {
        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $command->workspaceId,
            userId: $command->ownerId,
        );

        if ($command->deltaPoints === 0) {
            throw new \DomainException('Укажите ненулевое изменение баллов');
        }

        $account = $this->accounts->getOrCreate($command->workspaceId, $command->customerId);
        $account->adjust($command->deltaPoints);
        $this->accounts->save($account);

        $this->transactions->save(
            LoyaltyTransaction::buildNew(
                accountId: $account->id,
                workspaceId: $command->workspaceId,
                orderId: null,
                type: LoyaltyTransactionTypeEnum::ManualAdjust,
                points: $command->deltaPoints,
                balanceAfter: $account->pointsBalance,
                comment: $command->comment,
            ),
        );
    }
}
