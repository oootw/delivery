<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\User;

final class User
{
    private function __construct(
        public ?int $id,
        public readonly string $phone,
        public string $name,
        public bool $isAdmin,
    ) {}

    public static function buildNew(string $phone, string $name, bool $isAdmin = false): self
    {
        return new self(
            id: null,
            phone: $phone,
            name: $name,
            isAdmin: $isAdmin,
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}

