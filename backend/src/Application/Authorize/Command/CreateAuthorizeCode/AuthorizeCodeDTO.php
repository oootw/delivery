<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CreateAuthorizeCode;

class AuthorizeCodeDTO
{
    public function __construct(
        public int $id,
        public string $phone,
        public string $code,
        public string $codeType,
    ) {}
}
