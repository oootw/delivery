<?php

declare(strict_types=1);

namespace App\Console\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'app:core:contract',
    description: 'Печатает версию контракта ядра',
)]
final class CoreContractCommand extends Command
{
    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stderr = $output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output;
        $path = $this->projectDir.'/core-contract.json';

        if (!is_file($path)) {
            $stderr->writeln(sprintf('<error>Файл контракта ядра не найден: %s</error>', $path));

            return Command::FAILURE;
        }

        try {
            /** @var mixed $decoded */
            $decoded = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            $stderr->writeln(sprintf('<error>Некорректный JSON в core-contract.json: %s</error>', $exception->getMessage()));

            return Command::FAILURE;
        }

        if (!is_array($decoded)) {
            $stderr->writeln('<error>core-contract.json должен содержать JSON-объект</error>');

            return Command::FAILURE;
        }

        $contract = $decoded['contract'] ?? null;
        if (!is_string($contract)) {
            $stderr->writeln('<error>core-contract.json должен содержать строковое поле "contract"</error>');

            return Command::FAILURE;
        }

        if (!preg_match('/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)$/', $contract)) {
            $stderr->writeln('<error>Поле contract должно соответствовать строгому semver X.Y.Z</error>');

            return Command::FAILURE;
        }

        $output->writeln($contract);

        return Command::SUCCESS;
    }
}
