<?php

declare(strict_types=1);

namespace App\Tests\Unit\Authorize;

use App\Application\Authorize\Entity\Code\Code;
use App\Application\Authorize\Entity\Code\CodeTypeEnum;
use PHPUnit\Framework\TestCase;

final class CodeTest extends TestCase
{
    public function testMatchesIsExactAndNotUsedByDefault(): void
    {
        $code = $this->code(value: '1234');

        self::assertTrue($code->matches('1234'));
        self::assertFalse($code->matches('1235'));
        self::assertFalse($code->isUsed());
    }

    public function testIsExpiredAt(): void
    {
        $now = new \DateTimeImmutable('2026-07-12 12:00:00');
        $code = $this->code(expiresAt: $now->modify('-1 second'));

        self::assertTrue($code->isExpiredAt($now));
    }

    public function testNotExpiredExactlyAtExpiry(): void
    {
        $now = new \DateTimeImmutable('2026-07-12 12:00:00');
        $code = $this->code(expiresAt: $now);

        self::assertFalse($code->isExpiredAt($now));
    }

    public function testMarkUsedSetsUsedFlag(): void
    {
        $now = new \DateTimeImmutable();
        $code = $this->code();

        $code->markUsed($now);

        self::assertTrue($code->isUsed());
        self::assertSame($now, $code->usedAt);
    }

    public function testAttemptLimitReachedAfterEnoughFailures(): void
    {
        $code = $this->code();

        self::assertFalse($code->hasReachedAttemptLimit(3));

        $code->registerFailedAttempt();
        $code->registerFailedAttempt();
        self::assertFalse($code->hasReachedAttemptLimit(3));

        $code->registerFailedAttempt();
        self::assertTrue($code->hasReachedAttemptLimit(3));
    }

    private function code(
        string $value = '1234',
        ?\DateTimeImmutable $expiresAt = null,
    ): Code {
        return new Code(
            id: 1,
            phone: '+70000000000',
            code: $value,
            codeType: CodeTypeEnum::Authorize,
            expiresAt: $expiresAt ?? new \DateTimeImmutable('+5 minutes'),
        );
    }
}
