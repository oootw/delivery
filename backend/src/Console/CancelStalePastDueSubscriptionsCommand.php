<?php

declare(strict_types=1);

namespace App\Console;

use App\Application\Subscription\Command\CancelStalePastDueSubscriptions\CancelStalePastDueSubscriptionsCommand as CancelStalePastDueSubscriptions;
use App\Application\Subscription\Command\CancelStalePastDueSubscriptions\CancelStalePastDueSubscriptionsHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Крон-отмена подписок, надолго зависших в past_due (страховка на случай пропущенного
 * терминального recurrent-webhook CloudPayments). Запускается по cron (например, раз в сутки).
 */
#[AsCommand(
    name: 'app:subscriptions:cancel-past-due',
    description: 'Отменить подписки, провисевшие в past_due дольше grace-периода',
)]
final class CancelStalePastDueSubscriptionsCommand extends Command
{
    private const DEFAULT_GRACE_DAYS = 3;

    public function __construct(
        private readonly CancelStalePastDueSubscriptionsHandler $cancelStalePastDue,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            name: 'grace-days',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Сколько дней в past_due допустимо до автоотмены',
            default: self::DEFAULT_GRACE_DAYS,
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $graceDays = (int) $input->getOption('grace-days');

        if ($graceDays < 0) {
            $io->error('grace-days не может быть отрицательным');

            return Command::INVALID;
        }

        $canceled = $this->cancelStalePastDue->handle(new CancelStalePastDueSubscriptions($graceDays));

        $io->success(sprintf('Отменено просроченных подписок: %d', $canceled));

        return Command::SUCCESS;
    }
}
