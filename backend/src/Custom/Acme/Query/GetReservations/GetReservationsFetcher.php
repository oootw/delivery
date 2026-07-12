<?php

declare(strict_types=1);

namespace App\Custom\Acme\Query\GetReservations;

use App\Application\Customization\Access\CustomAccess;
use App\Custom\Acme\AcmeModule;
use App\Custom\Acme\Reservation\Reservation;
use App\Custom\Acme\Reservation\ReservationRepositoryInterface;

/**
 * Список броней воркспейса для менеджера. Гейтится по активности модуля и кастомной роли.
 */
class GetReservationsFetcher
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservations,
        private readonly CustomAccess $customAccess,
    ) {}

    /**
     * @return list<array<string, mixed>>
     */
    public function fetch(GetReservationsQuery $query): array
    {
        $this->customAccess->assertModuleActive($query->workspaceId, AcmeModule::SLUG);
        $this->customAccess->assertRole($query->workspaceId, $query->userId, AcmeModule::ROLE_RESERVATION_MANAGER);

        return array_map(
            static fn(Reservation $reservation): array => [
                'id' => $reservation->id,
                'venue_id' => $reservation->venueId,
                'guest_name' => $reservation->guestName,
                'guest_phone' => $reservation->guestPhone,
                'people_count' => $reservation->peopleCount,
                'desired_at' => $reservation->desiredAt->format(\DateTimeInterface::ATOM),
            ],
            $this->reservations->findByWorkspace($query->workspaceId),
        );
    }
}
