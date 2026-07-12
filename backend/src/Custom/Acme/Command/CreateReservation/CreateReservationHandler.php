<?php

declare(strict_types=1);

namespace App\Custom\Acme\Command\CreateReservation;

use App\Application\Customization\Access\CustomAccess;
use App\Application\Customization\Settings\WorkspaceSettingsReader;
use App\Custom\Acme\AcmeModule;
use App\Custom\Acme\Reservation\Reservation;
use App\Custom\Acme\Reservation\ReservationRepositoryInterface;
use App\Custom\Acme\Settings\AcmeSettingsProvider;

/**
 * Создание брони. Демонстрирует сквозную работу каркаса кастомизации:
 *  - гейтинг по активности модуля (иначе фичи как бы нет) и кастомной роли;
 *  - чтение настройки воркспейса (минимальный запас до брони) через WorkspaceSettingsReader.
 */
class CreateReservationHandler
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservations,
        private readonly CustomAccess $customAccess,
        private readonly WorkspaceSettingsReader $settings,
    ) {}

    public function handle(CreateReservationCommand $command): int
    {
        $this->customAccess->assertModuleActive($command->workspaceId, AcmeModule::SLUG);
        $this->customAccess->assertRole($command->workspaceId, $command->userId, AcmeModule::ROLE_RESERVATION_MANAGER);

        $leadTimeMinutes = $this->settings->int($command->workspaceId, AcmeSettingsProvider::LEAD_TIME_MINUTES);
        $earliest = (new \DateTimeImmutable())->modify(sprintf('+%d minutes', $leadTimeMinutes));

        if ($command->desiredAt < $earliest) {
            throw new \DomainException(sprintf('Бронь возможна не раньше чем за %d минут', $leadTimeMinutes));
        }

        return $this->reservations->save(
            Reservation::buildNew(
                workspaceId: $command->workspaceId,
                venueId: $command->venueId,
                guestName: $command->guestName,
                guestPhone: $command->guestPhone,
                peopleCount: $command->peopleCount,
                desiredAt: $command->desiredAt,
            ),
        );
    }
}
