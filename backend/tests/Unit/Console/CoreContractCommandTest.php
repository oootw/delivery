<?php

declare(strict_types=1);

namespace App\Tests\Unit\Console;

use App\Console\Command\CoreContractCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class CoreContractCommandTest extends TestCase
{
    public function testPrintsContractVersionFromCoreContractFile(): void
    {
        $command = new CoreContractCommand(\dirname(__DIR__, 3));
        $tester = new CommandTester($command);

        self::assertSame(Command::SUCCESS, $tester->execute([]));
        self::assertSame("1.0.0\n", $tester->getDisplay());
    }

    public function testFailsWhenContractIsNotStrictSemver(): void
    {
        $tmpDir = sys_get_temp_dir().'/core-contract-test-'.bin2hex(random_bytes(6));
        self::assertTrue(mkdir($tmpDir, 0777, true));
        file_put_contents($tmpDir.'/core-contract.json', '{"contract":"1.0"}');

        try {
            $command = new CoreContractCommand($tmpDir);
            $tester = new CommandTester($command);

            self::assertSame(Command::FAILURE, $tester->execute([], ['capture_stderr_separately' => true]));
            self::assertStringContainsString('строгому semver X.Y.Z', $tester->getErrorOutput());
        } finally {
            @unlink($tmpDir.'/core-contract.json');
            @rmdir($tmpDir);
        }
    }
}
