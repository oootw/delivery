<?php

declare(strict_types=1);

namespace App\Console;

use App\Application\Order\Command\ExpireAbandonedOrders\ExpireAbandonedOrdersCommand as ExpireAbandonedOrders;
use App\Application\Order\Command\ExpireAbandonedOrders\ExpireAbandonedOrdersHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Крон-истечение брошенных неоплаченных заказов: отменяет заказы в статусе created,
 * созданные раньше TTL, освобождая слоты промокодов и резерв баллов. Запускается по
 * cron (например, раз в 5 минут).
 */
#[AsCommand(
    name: 'app:orders:expire-abandoned',
    description: 'Отменить брошенные неоплаченные заказы и вернуть занятые ими слоты промо/баллы',
)]
final class ExpireAbandonedOrdersCommand extends Command
{
    private const DEFAULT_TTL_MINUTES = 30;

    public function __construct(
        private readonly ExpireAbandonedOrdersHandler $expireAbandonedOrders,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            name: 'ttl',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Через сколько минут неоплаченный заказ считается брошенным',
            default: self::DEFAULT_TTL_MINUTES,
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $ttlMinutes = (int) $input->getOption('ttl');

        if ($ttlMinutes < 1) {
            $io->error('TTL должен быть не меньше 1 минуты');

            return Command::INVALID;
        }

        $expired = $this->expireAbandonedOrders->handle(new ExpireAbandonedOrders($ttlMinutes));

        $io->success(sprintf('Истекло брошенных заказов: %d', $expired));

        return Command::SUCCESS;
    }
}
