<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CreateAuthorizeCode;

class CreateAuthorizeCodeCommand
{
    public function __construct(
        public string $phone,
        public string $codeType
    ) {}
}
