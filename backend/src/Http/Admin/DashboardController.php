<?php

declare(strict_types=1);

namespace App\Http\Admin;

use App\Infrastructure\Metrics\MetricsReader;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Дашборд глобальной админки. Стартовая страница показывает прикладные метрики
 * (нагрузка по минутам, заказы, подписки, очередь), меню ведёт к разделам:
 * пользователи/профили, подписки, заказы, воркспейсы, точки, POS и аудит.
 */
#[AdminDashboard(routePath: '/admin', routeName: 'admin_dashboard')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly MetricsReader $metricsReader,
    ) {}

    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'metrics' => $this->metricsReader->snapshot(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Delivery — админка')
            ->setFaviconPath('favicon.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Метрики', 'fa fa-chart-line');

        yield MenuItem::section('Продажи');
        yield MenuItem::linkTo(OrderCrudController::class, 'Заказы', 'fa fa-receipt');
        yield MenuItem::linkTo(SubscriptionCrudController::class, 'Подписки', 'fa fa-credit-card');

        yield MenuItem::section('Клиенты и точки');
        yield MenuItem::linkTo(UserCrudController::class, 'Пользователи', 'fa fa-users');
        yield MenuItem::linkTo(WorkspaceCrudController::class, 'Воркспейсы', 'fa fa-store');
        yield MenuItem::linkTo(VenueCrudController::class, 'Точки', 'fa fa-location-dot');
        yield MenuItem::linkTo(PosConnectionCrudController::class, 'POS-подключения', 'fa fa-plug');

        yield MenuItem::section('Аудит');
        yield MenuItem::linkTo(AuditRecordCrudController::class, 'История изменений', 'fa fa-clock-rotate-left');

        yield MenuItem::section();
        yield MenuItem::linkToLogout('Выйти', 'fa fa-arrow-right-from-bracket');
    }
}
