<?php

declare(strict_types=1);

namespace App\Console\Command;

use Composer\Semver\Semver;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'app:custom:check-compat',
    description: 'Проверяет совместимость overlay с контрактом ядра',
)]
final class CustomCheckCompatCommand extends Command
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

        $coreData = $this->readJsonFile($this->projectDir.'/core-contract.json', $stderr);
        if ($coreData === null) {
            return Command::FAILURE;
        }

        $manifestData = $this->readJsonFile($this->projectDir.'/custom/manifest.json', $stderr);
        if ($manifestData === null) {
            return Command::FAILURE;
        }

        $coreContract = $coreData['contract'] ?? null;
        if (!is_string($coreContract) || !preg_match('/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)$/', $coreContract)) {
            $stderr->writeln('<error>core-contract.json должен содержать поле "contract" в формате X.Y.Z</error>');

            return Command::FAILURE;
        }

        $requiredContract = $manifestData['core_contract'] ?? null;
        if (!is_string($requiredContract) || trim($requiredContract) === '') {
            $stderr->writeln('<error>custom/manifest.json должен содержать непустое строковое поле "core_contract"</error>');

            return Command::FAILURE;
        }

        try {
            $isCompatible = Semver::satisfies($coreContract, $requiredContract);
        } catch (\UnexpectedValueException $exception) {
            $stderr->writeln(sprintf(
                '<error>Некорректное semver-ограничение core_contract в manifest.json: %s</error>',
                $exception->getMessage(),
            ));

            return Command::FAILURE;
        }

        if (!$isCompatible) {
            $stderr->writeln(sprintf(
                '<error>Overlay требует контракт "%s", а ядро имеет "%s"</error>',
                $requiredContract,
                $coreContract,
            ));

            return Command::FAILURE;
        }

        $output->writeln(sprintf('OK: ядро %s совместимо с overlay (%s)', $coreContract, $requiredContract));

        return Command::SUCCESS;
    }

    /**
     * @return array<string, mixed>|null
     */
    private function readJsonFile(string $path, OutputInterface $stderr): ?array
    {
        if (!is_file($path)) {
            $stderr->writeln(sprintf('<error>Файл не найден: %s</error>', $path));

            return null;
        }

        try {
            /** @var mixed $decoded */
            $decoded = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            $stderr->writeln(sprintf('<error>Некорректный JSON в %s: %s</error>', $path, $exception->getMessage()));

            return null;
        }

        if (!is_array($decoded)) {
            $stderr->writeln(sprintf('<error>%s должен содержать JSON-объект</error>', $path));

            return null;
        }

        return $decoded;
    }
}
