<?php

declare(strict_types=1);

namespace App\Console\Command;

use App\Application\Customization\Scaffold\OverlayScaffolder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'app:custom:new',
    description: 'Создаёт каркас overlay для владельца',
)]
final class CustomNewCommand extends Command
{
    public function __construct(
        private readonly OverlayScaffolder $scaffolder,
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('owner', InputArgument::REQUIRED, 'Slug владельца (например: acme)')
            ->addOption('module', null, InputOption::VALUE_OPTIONAL, 'Slug первого модуля (по умолчанию = owner)')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Перезаписать существующие scaffold-файлы');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $ownerInput = (string) $input->getArgument('owner');
        $ownerSlug = $this->slugify($ownerInput);
        if ($ownerSlug === null) {
            $io->error('Некорректный owner slug. Разрешены буквы, цифры, "-", "_".');

            return self::FAILURE;
        }

        $moduleInput = (string) ($input->getOption('module') ?? $ownerSlug);
        $moduleSlug = $this->slugify($moduleInput);
        if ($moduleSlug === null) {
            $io->error('Некорректный module slug. Разрешены буквы, цифры, "-", "_".');

            return self::FAILURE;
        }

        $coreContract = $this->readCoreContractVersion();
        $ownerClass = $this->classify($ownerSlug);
        $moduleClass = $this->classify($moduleSlug);
        $force = (bool) $input->getOption('force');

        try {
            $result = $this->scaffolder->scaffold(
                ownerSlug: $ownerSlug,
                ownerClass: $ownerClass,
                moduleSlug: $moduleSlug,
                moduleClass: $moduleClass,
                coreContract: $coreContract,
                force: $force,
            );
        } catch (\RuntimeException $exception) {
            $io->error($exception->getMessage());

            return self::FAILURE;
        } catch (\Throwable $exception) {
            $io->error('Не удалось создать scaffold overlay: ' . $exception->getMessage());

            return self::FAILURE;
        }

        $io->success(sprintf(
            'Overlay scaffold создан: owner=%s, module=%s, core_contract=%s',
            $ownerSlug,
            $moduleSlug,
            $coreContract,
        ));

        if ($result->created !== []) {
            $io->section('Созданы файлы');
            $io->listing($result->created);
        }

        if ($result->updated !== []) {
            $io->section('Обновлены файлы');
            $io->listing($result->updated);
        }

        if ($result->unchanged !== []) {
            $io->section('Без изменений');
            $io->listing($result->unchanged);
        }

        return self::SUCCESS;
    }

    private function slugify(string $value): ?string
    {
        $normalized = strtolower(trim($value));
        $normalized = preg_replace('/[^a-z0-9_-]+/', '-', $normalized);
        $normalized = trim((string) $normalized, '-_');

        if ($normalized === '') {
            return null;
        }

        return $normalized;
    }

    private function classify(string $slug): string
    {
        $parts = preg_split('/[^a-z0-9]+/', strtolower($slug)) ?: [];
        $parts = array_values(array_filter($parts, static fn (string $part): bool => $part !== ''));

        if ($parts === []) {
            return 'Owner';
        }

        return implode('', array_map(static fn (string $part): string => ucfirst($part), $parts));
    }

    private function readCoreContractVersion(): string
    {
        $path = $this->projectDir . '/core-contract.json';
        if (!is_file($path)) {
            return '1.0.0';
        }

        try {
            /** @var mixed $decoded */
            $decoded = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return '1.0.0';
        }

        if (!is_array($decoded)) {
            return '1.0.0';
        }

        $contract = $decoded['contract'] ?? null;
        if (!is_string($contract) || trim($contract) === '') {
            return '1.0.0';
        }

        return trim($contract);
    }
}
