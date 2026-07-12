<?php

declare(strict_types=1);

namespace App\Http\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;

/**
 * Поставщик пунктов меню админки от клиентского модуля. Реализации (в src/Custom/{slug}/Http/Admin)
 * помечаются тегом app.custom_admin_menu; DashboardController добавляет их пункты, не зная про
 * конкретные клиентские классы (инвариант «ядро не знает Custom»).
 */
interface CustomAdminMenuContributorInterface
{
    /**
     * @return iterable<MenuItem>
     */
    public function menuItems(): iterable;
}
