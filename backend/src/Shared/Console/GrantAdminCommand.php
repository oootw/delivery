<?php

declare(strict_types=1);

namespace App\Shared\Console;

use App\Application\Authorize\Entity\User\UserRepositoryInterface;
use App\Infrastructure\Doctrine\Domain\Users\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepositoryInterface $users,
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

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['phone' => $phone]);

        if ($user === null) {
            $this->users->create($phone);
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['phone' => $phone]);
            $io->note(sprintf('Создан новый пользователь с телефоном %s', $phone));
        }

        $user->setIsAdmin(true);
        $user->setPassword($this->passwordHasher->hashPassword($user, (string) $input->getArgument('password')));

        $this->entityManager->flush();

        $io->success(sprintf('Пользователь %s теперь администратор', $phone));

        return Command::SUCCESS;
    }
}
