<?php

declare(strict_types=1);

namespace App\Console\Command;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:cp:import-legacy',
    description: 'Импортировать пользователей и подписки из legacy backend в control-plane',
)]
final class ImportLegacyDataCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly string $legacyDatabaseUrl,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($this->legacyDatabaseUrl === '') {
            $io->error('Не задан LEGACY_DATABASE_URL');

            return self::FAILURE;
        }

        try {
            $legacy = DriverManager::getConnection(['url' => $this->legacyDatabaseUrl]);
            $cp = $this->entityManager->getConnection();
        } catch (\Throwable $exception) {
            $io->error('Не удалось подключиться к БД: ' . $exception->getMessage());

            return self::FAILURE;
        }

        $importedUsers = 0;
        $importedSubscriptions = 0;

        try {
            $users = $legacy->fetchAllAssociative('SELECT id, phone, full_name, is_admin FROM "user"');
            foreach ($users as $user) {
                $phone = trim((string) ($user['phone'] ?? ''));
                if ($phone === '') {
                    continue;
                }

                $cp->executeStatement(
                    'INSERT INTO cp_user (phone, name, is_admin) VALUES (:phone, :name, :isAdmin)
                     ON CONFLICT (phone) DO NOTHING',
                    [
                        'phone' => $phone,
                        'name' => (string) ($user['full_name'] ?? $phone),
                        'isAdmin' => (bool) ($user['is_admin'] ?? false),
                    ],
                );

                $importedUsers++;
            }

            $subscriptions = $legacy->fetchAllAssociative('SELECT user_id, tarif_code, status, current_period_end FROM subscription');
            foreach ($subscriptions as $subscription) {
                $ownerId = (int) ($subscription['user_id'] ?? 0);
                if ($ownerId <= 0) {
                    continue;
                }

                $cp->executeStatement(
                    'INSERT INTO cp_owner_subscription (owner_id, tarif_code, status, valid_until)
                     VALUES (:ownerId, :tarifCode, :status, :validUntil)
                     ON CONFLICT (owner_id) DO UPDATE SET
                       tarif_code = EXCLUDED.tarif_code,
                       status = EXCLUDED.status,
                       valid_until = EXCLUDED.valid_until',
                    [
                        'ownerId' => $ownerId,
                        'tarifCode' => (string) ($subscription['tarif_code'] ?? 'basic'),
                        'status' => $this->normalizeStatus((string) ($subscription['status'] ?? 'expired')),
                        'validUntil' => $subscription['current_period_end'] ?? null,
                    ],
                );

                $importedSubscriptions++;
            }
        } catch (\Throwable $exception) {
            $io->error('Импорт прерван: ' . $exception->getMessage());

            return self::FAILURE;
        }

        $io->success(sprintf(
            'Импорт завершён. Пользователей: %d, подписок: %d',
            $importedUsers,
            $importedSubscriptions,
        ));

        return self::SUCCESS;
    }

    private function normalizeStatus(string $status): string
    {
        return match ($status) {
            'active', 'past_due', 'suspended', 'expired' => $status,
            default => 'expired',
        };
    }
}

