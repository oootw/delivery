<?php

declare(strict_types=1);

namespace App\Custom\Acme\Reservation;

interface ReservationRepositoryInterface
{
    public function save(Reservation $reservation): int;

    /**
     * Брони воркспейса, ближайшие сверху по времени визита.
     *
     * @return Reservation[]
     */
    public function findByWorkspace(int $workspaceId): array;
}
