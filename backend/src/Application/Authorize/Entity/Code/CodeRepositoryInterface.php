<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\Code;

interface CodeRepositoryInterface
{
    public function validateCodeByCreatedAt(string $phone): bool;

    public function countCreatedSince(string $phone, \DateTime $since): int;

    public function validateCode(Code $code): bool;

    public function create(Code $code): int;
}
