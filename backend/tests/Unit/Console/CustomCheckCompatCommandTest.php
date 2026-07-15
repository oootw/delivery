<?php

declare(strict_types=1);

namespace App\Tests\Unit\Console;

use App\Console\Command\CustomCheckCompatCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class CustomCheckCompatCommandTest extends TestCase
{
    public function testReturnsSuccessForCompatibleContract(): void
    {
        $command = new CustomCheckCompatCommand(\dirname(__DIR__, 3));
        $tester = new CommandTester($command);

        self::assertSame(Command::SUCCESS, $tester->execute([]));
        self::assertStringContainsString('OK: ядро 1.0.0 совместимо с overlay', $tester->getDisplay());
    }

    public function testReturnsFailureForIncompatibleContract(): void
    {
        $tmpDir = sys_get_temp_dir().'/custom-compat-test-'.bin2hex(random_bytes(6));
        self::assertTrue(mkdir($tmpDir.'/custom', 0777, true));
        file_put_contents($tmpDir.'/core-contract.json', '{"contract":"1.0.0"}');
        file_put_contents(
            $tmpDir.'/custom/manifest.json',
            '{"owner":"acme","core_contract":"^2.0","modules":["acme"]}',
        );

        try {
            $command = new CustomCheckCompatCommand($tmpDir);
            $tester = new CommandTester($command);

            self::assertSame(Command::FAILURE, $tester->execute([], ['capture_stderr_separately' => true]));
            self::assertStringContainsString('Overlay требует контракт "^2.0"', $tester->getErrorOutput());
        } finally {
            @unlink($tmpDir.'/custom/manifest.json');
            @unlink($tmpDir.'/core-contract.json');
            @rmdir($tmpDir.'/custom');
            @rmdir($tmpDir);
        }
    }
}
