<?php

declare(strict_types=1);

namespace App\Tests\Unit\Authorize;

use App\Application\Authorize\Command\CheckOntimeCode\CheckOntimeCodeCommand;
use App\Application\Authorize\Command\CheckOntimeCode\CheckOntimeCodeHandler;
use App\Application\Authorize\Entity\Code\Code;
use App\Application\Authorize\Entity\Code\CodeRepositoryInterface;
use App\Application\Authorize\Entity\Code\CodeTypeEnum;
use PHPUnit\Framework\TestCase;

final class CheckOntimeCodeHandlerTest extends TestCase
{
    public function testValidCodeIsBurnedAfterSuccess(): void
    {
        $code = $this->activeCode('1234');
        $handler = new CheckOntimeCodeHandler($repo = $this->repo($code));

        $handler->handle($this->command('1234'));

        self::assertTrue($code->isUsed());
        self::assertSame(1, $repo->saveCalls);
    }

    public function testMissingCodeIsRejected(): void
    {
        $handler = new CheckOntimeCodeHandler($this->repo(null));

        $this->expectException(\DomainException::class);
        $handler->handle($this->command('1234'));
    }

    public function testExpiredCodeIsRejected(): void
    {
        $code = $this->activeCode('1234', expiresAt: new \DateTimeImmutable('-1 second'));
        $handler = new CheckOntimeCodeHandler($this->repo($code));

        $this->expectException(\DomainException::class);
        $handler->handle($this->command('1234'));
    }

    public function testUsedCodeIsRejected(): void
    {
        $code = $this->activeCode('1234');
        $code->markUsed(new \DateTimeImmutable());
        $handler = new CheckOntimeCodeHandler($this->repo($code));

        $this->expectException(\DomainException::class);
        $handler->handle($this->command('1234'));
    }

    public function testWrongCodeCountsAttemptAndPersists(): void
    {
        $code = $this->activeCode('1234');
        $handler = new CheckOntimeCodeHandler($repo = $this->repo($code));

        try {
            $handler->handle($this->command('0000'));
            self::fail('Ожидалось исключение на неверный код');
        } catch (\DomainException) {
        }

        self::assertSame(1, $code->attempts);
        self::assertFalse($code->isUsed());
        self::assertSame(1, $repo->saveCalls);
    }

    public function testCodeBurnsOnThirdWrongAttempt(): void
    {
        $code = $this->activeCode('1234');
        $handler = new CheckOntimeCodeHandler($this->repo($code));

        for ($i = 0; $i < 3; $i++) {
            try {
                $handler->handle($this->command('0000'));
            } catch (\DomainException) {
            }
        }

        self::assertSame(3, $code->attempts);
        self::assertTrue($code->isUsed(), 'Код должен сгореть после лимита попыток');
    }

    public function testCorrectCodeRejectedAfterAttemptLimit(): void
    {
        $code = $this->activeCode('1234');
        $code->registerFailedAttempt();
        $code->registerFailedAttempt();
        $code->registerFailedAttempt();
        $handler = new CheckOntimeCodeHandler($this->repo($code));

        $this->expectException(\DomainException::class);
        $handler->handle($this->command('1234'));
    }

    private function command(string $code): CheckOntimeCodeCommand
    {
        return new CheckOntimeCodeCommand(
            phone: '+70000000000',
            code: $code,
            codeType: CodeTypeEnum::Authorize->value,
        );
    }

    private function activeCode(string $value, ?\DateTimeImmutable $expiresAt = null): Code
    {
        return new Code(
            id: 1,
            phone: '+70000000000',
            code: $value,
            codeType: CodeTypeEnum::Authorize,
            expiresAt: $expiresAt ?? new \DateTimeImmutable('+5 minutes'),
        );
    }

    private function repo(?Code $code): CodeRepositoryInterface
    {
        return new class($code) implements CodeRepositoryInterface {
            public int $saveCalls = 0;

            public function __construct(private ?Code $code) {}

            public function findActiveCode(string $phone, CodeTypeEnum $codeType): ?Code
            {
                return $this->code;
            }

            public function hasRecentCode(string $phone, \DateTimeImmutable $since): bool
            {
                return false;
            }

            public function countCreatedSince(string $phone, \DateTime $since): int
            {
                return 0;
            }

            public function save(Code $code): void
            {
                $this->saveCalls++;
            }

            public function create(Code $code): int
            {
                return 1;
            }
        };
    }
}
