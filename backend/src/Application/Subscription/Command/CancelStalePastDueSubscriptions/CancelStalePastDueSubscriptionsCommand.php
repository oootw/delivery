<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\CancelStalePastDueSubscriptions;

/**
 * Догоняющая отмена подписок, надолго зависших в past_due. Обычно терминальный
 * recurrent-webhook CloudPayments уже переводит их в canceled; крон — страховка на
 * случай пропущенной нотификации.
 */
class CancelStalePastDueSubscriptionsCommand
{
    public function __construct(
        /** Сколько дней в past_due допустимо до автоматической отмены. */
        public readonly int $graceDays,
    ) {}
}
