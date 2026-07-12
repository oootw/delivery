<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\Code;

class Code
{
    public function __construct(
        public ?int $id,
        public string $phone,
        public string $code,
        public CodeTypeEnum $codeType,
        public ?\DateTimeImmutable $expiresAt = null,
        public ?\DateTimeImmutable $usedAt = null,
        public int $attempts = 0,
    ) {}

    public static function buildNew(string $phone, CodeTypeEnum $codeType, string $code): self
    {
        return new self(
            id: null,
            phone: $phone,
            code: $code,
            codeType: $codeType,
        );
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function isExpiredAt(\DateTimeImmutable $now): bool
    {
        return $this->expiresAt !== null && $this->expiresAt < $now;
    }

    public function isUsed(): bool
    {
        return $this->usedAt !== null;
    }

    /** Сравнение через hash_equals — постоянное время, без утечки по таймингу. */
    public function matches(string $input): bool
    {
        return hash_equals($this->code, $input);
    }

    public function registerFailedAttempt(): void
    {
        $this->attempts++;
    }

    public function hasReachedAttemptLimit(int $maxAttempts): bool
    {
        return $this->attempts >= $maxAttempts;
    }

    public function markUsed(\DateTimeImmutable $now): void
    {
        $this->usedAt = $now;
    }
}
