<?php

declare(strict_types=1);

namespace App\Console\Command;

use App\Application\License\Contract\LicenseProviderInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:license:refresh',
    description: 'Принудительно обновить кэш лицензии из control-plane',
)]
final class LicenseRefreshCommand extends Command
{
    public function __construct(
        private readonly LicenseProviderInterface $licenseProvider,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $snapshot = $this->licenseProvider->refresh();
        } catch (\Throwable $exception) {
            $io->error('Не удалось обновить лицензию: ' . $exception->getMessage());

            return self::FAILURE;
        }

        $io->success(sprintf(
            'Лицензия обновлена: тариф=%s, статус=%s, fetched_at=%s',
            $snapshot->tarifCode->value,
            $snapshot->status->value,
            $snapshot->fetchedAt->format(\DateTimeInterface::ATOM),
        ));

        return self::SUCCESS;
    }
}

