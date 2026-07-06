<?php

declare(strict_types=1);

namespace App\Application\Authorize\Events\CreateNewUserEvent;

class CreateNewUserEventPayload
{
    public function __construct(
        public int $userId,
        public string $phone,
        public string $name,
        public \DateTime $birthDate,
        public \DateTimeImmutable $createdAt,
    ) {}
}
