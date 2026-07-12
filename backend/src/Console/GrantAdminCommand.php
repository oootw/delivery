<?php

declare(strict_types=1);

namespace App\Console;

use App\Application\Authorize\Command\GrantAdmin\GrantAdminCommand as GrantAdmin;
use App\Application\Authorize\Command\GrantAdmin\GrantAdminHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Выдаёт пользователю права администратора и задаёт пароль для входа в админку.
 * Пример: php bin/console app:admin:grant +79990001122 secret123
 */
#[AsCommand(
    name: 'app:admin:grant',
    description: 'Сделать пользователя администратором и задать пароль для входа в админку',
)]
final class GrantAdminCommand extends Command
{
    public function __construct(
        private readonly GrantAdminHandler $grantAdmin,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('phone', InputArgument::REQUIRED, 'Телефон пользователя (как при регистрации)')
            ->addArgument('password', InputArgument::REQUIRED, 'Пароль для входа в админку');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $phone = (string) $input->getArgument('phone');

        $created = $this->grantAdmin->handle(
            new GrantAdmin(
                phone: $phone,
                plainPassword: (string) $input->getArgument('password'),
            ),
        );

        if ($created) {
            $io->note(sprintf('Создан новый пользователь с телефоном %s', $phone));
        }

        $io->success(sprintf('Пользователь %s теперь администратор', $phone));

        return Command::SUCCESS;
    }
}
