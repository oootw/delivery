<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Billing;

use App\Shared\Contract\Payment\PaymentProviderEnum;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkspacePaymentSettingsRepository::class)]
#[ORM\Table(name: 'workspace_payment_settings')]
#[ORM\UniqueConstraint(name: 'uniq_workspace_payment_settings_workspace', columns: ['workspace_id'])]
class WorkspacePaymentSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column(length: 32, enumType: PaymentProviderEnum::class)]
    private PaymentProviderEnum $provider;

    #[ORM\Column(type: 'text')]
    private string $credentialsEncrypted;

    #[ORM\Column]
    private bool $isActive = false;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkspaceId(): int
    {
        return $this->workspaceId;
    }

    public function setWorkspaceId(int $workspaceId): static
    {
        $this->workspaceId = $workspaceId;

        return $this;
    }

    public function getProvider(): PaymentProviderEnum
    {
        return $this->provider;
    }

    public function setProvider(PaymentProviderEnum $provider): static
    {
        $this->provider = $provider;

        return $this;
    }

    public function getCredentialsEncrypted(): string
    {
        return $this->credentialsEncrypted;
    }

    public function setCredentialsEncrypted(string $credentialsEncrypted): static
    {
        $this->credentialsEncrypted = $credentialsEncrypted;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
