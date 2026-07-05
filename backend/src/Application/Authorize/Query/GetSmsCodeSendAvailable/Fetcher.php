<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\GetSmsCodeSendAvailable;

use App\Application\Authorize\Entity\Code\CodeRepositoryInterface;

class Fetcher
{
    public function __construct(
        private readonly CodeRepositoryInterface $codes
    ) {}

    public function fetch(Query $query): bool
    {
        return $this->codes->validateCodeByCreatedAt($query->phone);
    }
}
