<?php

declare(strict_types=1);

namespace App\Application\Authorize\Query\FindUserByPhone;

class FindUserByPhoneQuery
{
    public function __construct(
        public readonly string $phone,
    ) {}
}
