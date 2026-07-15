<?php

declare(strict_types=1);

namespace App\Console\Command;

use App\Application\Customization\Doctor\DoctorIssue;
use App\Application\Customization\Doctor\OverlayDoctor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:custom:doctor',
    description: 'Проверяет overlay на ошибки совместимости и структуры',
)]
final class CustomDoctorCommand extends Command
{
    private const EXIT_OK = 0;
    private const EXIT_VALIDATION_FAILED = 2;
    private const EXIT_RUNTIME_ERROR = 3;

    public function __construct(
        private readonly OverlayDoctor $overlayDoctor,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $report = $this->overlayDoctor->run();
        } catch (\Throwable $exception) {
            $io->error('doctor завершился с внутренней ошибкой: ' . $exception->getMessage());
            $io->writeln(sprintf('exit_code=%d', self::EXIT_RUNTIME_ERROR));

            return self::EXIT_RUNTIME_ERROR;
        }

        $issues = $report->all();
        if ($issues === []) {
            $io->success('Overlay проверен: проблем не найдено.');
            $io->writeln(sprintf('exit_code=%d', self::EXIT_OK));

            return self::EXIT_OK;
        }

        $io->title('Результаты app:custom:doctor');
        foreach ($issues as $issue) {
            $this->renderIssue($io, $issue);
        }

        $warnings = count($report->warnings());
        $errors = count($report->errors());
        $io->newLine();
        $io->writeln(sprintf('summary: errors=%d warnings=%d', $errors, $warnings));

        if ($errors > 0) {
            $io->error('Найдены блокирующие ошибки overlay.');
            $io->writeln(sprintf('exit_code=%d', self::EXIT_VALIDATION_FAILED));

            return self::EXIT_VALIDATION_FAILED;
        }

        $io->warning('Найдены предупреждения, но блокирующих ошибок нет.');
        $io->writeln(sprintf('exit_code=%d', self::EXIT_OK));

        return self::EXIT_OK;
    }

    private function renderIssue(SymfonyStyle $io, DoctorIssue $issue): void
    {
        $pathPart = $issue->path !== null ? sprintf(' [%s]', $issue->path) : '';
        $line = sprintf('%s %s%s — %s', strtoupper($issue->severity), $issue->code, $pathPart, $issue->message);

        if ($issue->severity === 'error') {
            $io->writeln('<error>' . $line . '</error>');

            return;
        }

        $io->writeln('<comment>' . $line . '</comment>');
    }
}
