<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Entity\Account;

interface LoyaltyAccountRepositoryInterface
{
    public function save(LoyaltyAccount $account): int;

    public function findByCustomer(int $workspaceId, int $customerId): ?LoyaltyAccount;

    public function getOrCreate(int $workspaceId, int $customerId): LoyaltyAccount;

    /**
     * То же, что getOrCreate, но с пессимистичной блокировкой строки кошелька
     * (SELECT … FOR UPDATE) — сериализует конкурентный резерв баллов, чтобы два
     * параллельных заказа не зарезервировали больше доступного. Требует активной
     * транзакции у вызывающего.
     */
    public function getOrCreateForUpdate(int $workspaceId, int $customerId): LoyaltyAccount;

    /**
     * Кошельки воркспейса с положительным балансом — для крон-экспирации баллов.
     *
     * @return LoyaltyAccount[]
     */
    public function findByWorkspaceWithPoints(int $workspaceId): array;
}
