<?php

declare(strict_types=1);

namespace App\Custom\Acme\Http\Admin;

use App\Http\Admin\CustomAdminMenuContributorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;

/**
 * Раздел админки модуля Acme. Помечается тегом app.custom_admin_menu (через _instanceof) и
 * подхватывается DashboardController — ядро не знает про этот класс.
 */
final class AcmeAdminMenuContributor implements CustomAdminMenuContributorInterface
{
    public function menuItems(): iterable
    {
        yield MenuItem::section('Acme');
        yield MenuItem::linkTo(ReservationCrudController::class, 'Брони столов', 'fa fa-calendar-check');
    }
}
