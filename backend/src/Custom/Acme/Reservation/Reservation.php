<?php

declare(strict_types=1);

namespace App\Custom\Acme\Reservation;

/**
 * Бронь стола (доменная сущность модуля Acme). Ключуется на числовой workspace_id.
 * Персистится в таблицу custom_acme_reservation (Doctrine-зеркало в Infrastructure/Doctrine).
 */
class Reservation
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public int $venueId,
        public string $guestName,
        public string $guestPhone,
        public int $peopleCount,
        public \DateTimeImmutable $desiredAt,
        public \DateTimeImmutable $createdAt,
    ) {}

    public static function buildNew(
        int $workspaceId,
        int $venueId,
        string $guestName,
        string $guestPhone,
        int $peopleCount,
        \DateTimeImmutable $desiredAt,
    ): self {
        $guestName = trim($guestName);
        $guestPhone = trim($guestPhone);

        if ($guestName === '') {
            throw new \DomainException('Укажите имя гостя');
        }

        if ($guestPhone === '') {
            throw new \DomainException('Укажите телефон гостя');
        }

        if ($peopleCount < 1) {
            throw new \DomainException('Число гостей должно быть не меньше 1');
        }

        return new self(
            id: null,
            workspaceId: $workspaceId,
            venueId: $venueId,
            guestName: $guestName,
            guestPhone: $guestPhone,
            peopleCount: $peopleCount,
            desiredAt: $desiredAt,
            createdAt: new \DateTimeImmutable(),
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
