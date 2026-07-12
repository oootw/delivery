<?php

declare(strict_types=1);

namespace App\Application\Workspace\Command\AddStaffMember;

/**
 * Владелец добавляет в воркспейс сотрудника по номеру телефона.
 * Сотрудник должен быть уже зарегистрирован в системе.
 */
class AddStaffMemberCommand
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly string $staffPhone,
    ) {}
}
