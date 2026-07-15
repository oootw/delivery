<?php

declare(strict_types=1);

namespace App\Console\Command;

use App\Application\Heartbeat\Contract\HeartbeatClientInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fleet:heartbeat',
    description: 'Отправить heartbeat в control-plane',
)]
final class SendHeartbeatCommand extends Command
{
    public function __construct(
        private readonly HeartbeatClientInterface $heartbeatClient,
        private readonly string $coreRef,
        private readonly string $coreContractVersion,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->heartbeatClient->send(
                coreRef: $this->coreRef,
                contractVersion: $this->coreContractVersion,
                healthStatus: 'ok',
            );
        } catch (\Throwable $exception) {
            $io->error('Не удалось отправить heartbeat: ' . $exception->getMessage());

            return self::FAILURE;
        }

        $io->success('Heartbeat успешно отправлен');

        return self::SUCCESS;
    }
}

