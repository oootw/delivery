<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\GetSmsCodeSendAvailable;

use App\Application\Authorize\Entity\Code\CodeRepositoryInterface;

class GetSmsCodeSendAvailableFetcher
{
    /** Минимальный интервал между отправками кода на один номер. */
    private const RESEND_COOLDOWN = '-60 seconds';

    public function __construct(
        private readonly CodeRepositoryInterface $codes
    ) {}

    public function fetch(GetSmsCodeSendAvailableQuery $query): bool
    {
        $cooldownStart = (new \DateTimeImmutable())->modify(self::RESEND_COOLDOWN);

        return !$this->codes->hasRecentCode($query->phone, $cooldownStart);
    }
}
