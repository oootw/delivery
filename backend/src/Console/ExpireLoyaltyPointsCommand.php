<?php

declare(strict_types=1);

namespace App\Console;

use App\Application\Loyalty\Command\ExpirePoints\ExpirePointsCommand;
use App\Application\Loyalty\Command\ExpirePoints\ExpirePointsHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Крон-сгорание баллов по сроку жизни (pointsLifetimeDays каждой программы лояльности).
 * Запускается по cron (например, раз в сутки).
 */
#[AsCommand(
    name: 'app:loyalty:expire-points',
    description: 'Сжечь баллы, начисленные раньше срока жизни и не потраченные (FIFO)',
)]
final class ExpireLoyaltyPointsCommand extends Command
{
    public function __construct(
        private readonly ExpirePointsHandler $expirePoints,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $expired = $this->expirePoints->handle(new ExpirePointsCommand());

        $io->success(sprintf('Сгорело баллов: %d', $expired));

        return Command::SUCCESS;
    }
}
