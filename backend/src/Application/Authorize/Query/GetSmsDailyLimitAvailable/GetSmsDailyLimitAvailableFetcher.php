<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\GetSmsDailyLimitAvailable;

use App\Application\Authorize\Entity\Code\CodeRepositoryInterface;

/**
 * Не превышен ли суточный лимит запросов кода на номер — защита от SMS-бомбинга
 * и лишних расходов. Считается по номеру (не по пользователю), чтобы лимит не
 * раскрывал, зарегистрирован ли номер.
 */
class GetSmsDailyLimitAvailableFetcher
{
    /** Максимум запросов кода на один номер за сутки. */
    private const DAILY_LIMIT = 10;

    public function __construct(
        private readonly CodeRepositoryInterface $codes,
    ) {}

    public function fetch(GetSmsDailyLimitAvailableQuery $query): bool
    {
        $since = new \DateTime('-24 hours');

        return $this->codes->countCreatedSince($query->phone, $since) < self::DAILY_LIMIT;
    }
}
