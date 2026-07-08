<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Subscription;

use App\Application\Tarif\Entity\Tarif\TarifCodeEnum;
use App\Infrastructure\Doctrine\Domain\Subscription\SubscriptionRepository;
use App\Application\Subscription\Entity\Subscription\SubscriptionStatusEnum;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
#[ORM\Table(name: 'subscription')]
#[ORM\Index(name: 'idx_subscription_user', columns: ['user_id'])]
#[ORM\Index(name: 'idx_subscription_external_id', columns: ['external_id'])]
class Subscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $userId;

    #[ORM\Column(enumType: TarifCodeEnum::class)]
    private TarifCodeEnum $tarifCode;

    #[ORM\Column(enumType: SubscriptionStatusEnum::class)]
    private SubscriptionStatusEnum $status;

    #[ORM\Column(length: 36, unique: true)]
    private string $invoiceId;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $externalId = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $currentPeriodEnd = null;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getTarifCode(): TarifCodeEnum
    {
        return $this->tarifCode;
    }

    public function setTarifCode(TarifCodeEnum $tarifCode): void
    {
        $this->tarifCode = $tarifCode;
    }

    public function getStatus(): SubscriptionStatusEnum
    {
        return $this->status;
    }

    public function setStatus(SubscriptionStatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getInvoiceId(): string
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(string $invoiceId): void
    {
        $this->invoiceId = $invoiceId;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getCurrentPeriodEnd(): ?\DateTimeImmutable
    {
        return $this->currentPeriodEnd;
    }

    public function setCurrentPeriodEnd(?\DateTimeImmutable $currentPeriodEnd): void
    {
        $this->currentPeriodEnd = $currentPeriodEnd;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
