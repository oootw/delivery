<?php

declare(strict_types=1);

namespace App\Application\Billing\Entity\WorkspacePaymentSettings;

use App\Shared\Contract\Payment\PaymentProviderEnum;

/**
 * Настройка платёжного провайдера воркспейса для оплаты заказов гостями. Одна на
 * воркспейс. Креды провайдера (ключи мерчант-аккаунта владельца) хранятся зашифрованными.
 * Подписки владельца этой настройкой не управляются — они всегда идут через платформенный
 * CloudPayments.
 */
class WorkspacePaymentSettings
{
    /** @param array<string, string> $credentials */
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public PaymentProviderEnum $provider,
        public array $credentials,
        public bool $isActive,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(int $workspaceId): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            workspaceId: $workspaceId,
            provider: PaymentProviderEnum::CloudPayments,
            credentials: [],
            isActive: false,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    /** @param array<string, string> $credentials */
    public function configure(PaymentProviderEnum $provider, array $credentials, bool $isActive): void
    {
        $this->provider = $provider;
        $this->credentials = $credentials;
        $this->isActive = $isActive;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
