<?php

declare(strict_types=1);

namespace App\Http\Admin;

use App\Infrastructure\Doctrine\Domain\Audit\AuditRecord;
use App\Infrastructure\Doctrine\Domain\Order\Order;
use App\Infrastructure\Doctrine\Domain\PosIntegration\PosConnection;
use App\Infrastructure\Doctrine\Domain\Subscription\Subscription;
use App\Infrastructure\Doctrine\Domain\Users\User;
use App\Infrastructure\Doctrine\Domain\Venue\Venue;
use App\Infrastructure\Doctrine\Domain\Workspace\Workspace;
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
        yield MenuItem::linkToCrud('Заказы', 'fa fa-receipt', Order::class);
        yield MenuItem::linkToCrud('Подписки', 'fa fa-credit-card', Subscription::class);

        yield MenuItem::section('Клиенты и точки');
        yield MenuItem::linkToCrud('Пользователи', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Воркспейсы', 'fa fa-store', Workspace::class);
        yield MenuItem::linkToCrud('Точки', 'fa fa-location-dot', Venue::class);
        yield MenuItem::linkToCrud('POS-подключения', 'fa fa-plug', PosConnection::class);

        yield MenuItem::section('Аудит');
        yield MenuItem::linkToCrud('История изменений', 'fa fa-clock-rotate-left', AuditRecord::class);

        yield MenuItem::section();
        yield MenuItem::linkToRoute('Выйти', 'fa fa-arrow-right-from-bracket', 'admin_logout');
    }
}
