<?php

declare(strict_types=1);

namespace App\Shared\Console;

use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\WaitTime\WaitTimeRecalculatorInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Таймерный пересчёт времени ожидания. Проходит по точкам с активными заказами
 * и обновляет ETA, чтобы оценка «таяла» со временем даже без событий заказов.
 * Запускается по cron (например, раз в минуту).
 */
#[AsCommand(
    name: 'app:wait-time:recalculate',
    description: 'Пересчитать время ожидания для всех точек с активными заказами',
)]
final class RecalculateWaitTimesCommand extends Command
{
    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly WaitTimeRecalculatorInterface $waitTimeRecalculator,
    ) {
        parent::__construct();
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $venueIds = $this->orders->findVenueIdsInProgress();

        foreach ($venueIds as $venueId) {
            $this->waitTimeRecalculator->recalculateForVenue($venueId);
        }

        $io->success(sprintf('Пересчитано точек: %d', count($venueIds)));

        return Command::SUCCESS;
    }
}
