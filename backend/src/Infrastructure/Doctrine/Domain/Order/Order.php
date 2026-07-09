<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Order;

use App\Application\Order\Entity\Order\OrderStatusEnum;
use App\Application\Order\Entity\Order\OrderTypeEnum;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '"order"')]
#[ORM\Index(name: 'idx_order_customer', columns: ['customer_id'])]
#[ORM\Index(name: 'idx_order_venue', columns: ['venue_id'])]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column]
    private int $venueId;

    #[ORM\Column]
    private int $customerId;

    #[ORM\Column(enumType: OrderTypeEnum::class)]
    private OrderTypeEnum $type;

    #[ORM\Column(enumType: OrderStatusEnum::class)]
    private OrderStatusEnum $status;

    /** @var array<int, array<string, mixed>> */
    #[ORM\Column(type: 'json')]
    private array $items = [];

    #[ORM\Column]
    private int $subtotalKopecks = 0;

    #[ORM\Column]
    private int $discountKopecks = 0;

    /** @var array<int, array<string, mixed>> */
    #[ORM\Column(type: 'json')]
    private array $appliedDiscounts = [];

    #[ORM\Column]
    private int $pointsSpent = 0;

    #[ORM\Column]
    private int $pointsEarned = 0;

    #[ORM\Column]
    private int $totalKopecks;

    #[ORM\Column(length: 255)]
    private string $contactName;

    #[ORM\Column(length: 32)]
    private string $contactPhone;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $deliveryAddress = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(length: 36, unique: true)]
    private string $invoiceId;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $externalPaymentId = null;

    #[ORM\Column(nullable: true)]
    private ?int $estimatedWaitMinutes = null;

    /** @var array<int, array<string, mixed>> */
    #[ORM\Column(type: 'json')]
    private array $history = [];

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

    public function setWorkspaceId(int $workspaceId): void
    {
        $this->workspaceId = $workspaceId;
    }

    public function getVenueId(): int
    {
        return $this->venueId;
    }

    public function setVenueId(int $venueId): void
    {
        $this->venueId = $venueId;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getType(): OrderTypeEnum
    {
        return $this->type;
    }

    public function setType(OrderTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getStatus(): OrderStatusEnum
    {
        return $this->status;
    }

    public function setStatus(OrderStatusEnum $status): void
    {
        $this->status = $status;
    }

    /** @return array<int, array<string, mixed>> */
    public function getItems(): array
    {
        return $this->items;
    }

    /** @param array<int, array<string, mixed>> $items */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function getSubtotalKopecks(): int
    {
        return $this->subtotalKopecks;
    }

    public function setSubtotalKopecks(int $subtotalKopecks): void
    {
        $this->subtotalKopecks = $subtotalKopecks;
    }

    public function getDiscountKopecks(): int
    {
        return $this->discountKopecks;
    }

    public function setDiscountKopecks(int $discountKopecks): void
    {
        $this->discountKopecks = $discountKopecks;
    }

    /** @return array<int, array<string, mixed>> */
    public function getAppliedDiscounts(): array
    {
        return $this->appliedDiscounts;
    }

    /** @param array<int, array<string, mixed>> $appliedDiscounts */
    public function setAppliedDiscounts(array $appliedDiscounts): void
    {
        $this->appliedDiscounts = $appliedDiscounts;
    }

    public function getPointsSpent(): int
    {
        return $this->pointsSpent;
    }

    public function setPointsSpent(int $pointsSpent): void
    {
        $this->pointsSpent = $pointsSpent;
    }

    public function getPointsEarned(): int
    {
        return $this->pointsEarned;
    }

    public function setPointsEarned(int $pointsEarned): void
    {
        $this->pointsEarned = $pointsEarned;
    }

    public function getTotalKopecks(): int
    {
        return $this->totalKopecks;
    }

    public function setTotalKopecks(int $totalKopecks): void
    {
        $this->totalKopecks = $totalKopecks;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function setContactName(string $contactName): void
    {
        $this->contactName = $contactName;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    public function setContactPhone(string $contactPhone): void
    {
        $this->contactPhone = $contactPhone;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?string $deliveryAddress): void
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getInvoiceId(): string
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(string $invoiceId): void
    {
        $this->invoiceId = $invoiceId;
    }

    public function getExternalPaymentId(): ?string
    {
        return $this->externalPaymentId;
    }

    public function setExternalPaymentId(?string $externalPaymentId): void
    {
        $this->externalPaymentId = $externalPaymentId;
    }

    public function getEstimatedWaitMinutes(): ?int
    {
        return $this->estimatedWaitMinutes;
    }

    public function setEstimatedWaitMinutes(?int $estimatedWaitMinutes): void
    {
        $this->estimatedWaitMinutes = $estimatedWaitMinutes;
    }

    /** @return array<int, array<string, mixed>> */
    public function getHistory(): array
    {
        return $this->history;
    }

    /** @param array<int, array<string, mixed>> $history */
    public function setHistory(array $history): void
    {
        $this->history = $history;
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
