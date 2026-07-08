<?php

declare(strict_types=1);

namespace App\Application\Workspace\Entity\Membership;

enum MembershipRoleEnum: string
{
    /** Владелец воркспейса: создатель, управляет составом и точками. */
    case Owner = 'owner';

    /** Сотрудник: работает внутри воркспейса без прав владельца. */
    case Staff = 'staff';
}
