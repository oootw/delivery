<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Promotion;

use App\Application\Promotion\Entity\Promotion\PromotionTargetEnum;
use App\Application\Promotion\Entity\Promotion\PromotionTypeEnum;
use App\Application\Promotion\Entity\Promotion\RewardTypeEnum;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
#[ORM\Table(name: 'promotion')]
#[ORM\Index(name: 'idx_promotion_workspace', columns: ['workspace_id'])]
#[ORM\Index(name: 'idx_promotion_venue', columns: ['venue_id'])]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column(nullable: true)]
    private ?int $venueId = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 20, enumType: PromotionTypeEnum::class)]
    private PromotionTypeEnum $type;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 20, enumType: RewardTypeEnum::class)]
    private RewardTypeEnum $rewardType;

    #[ORM\Column]
    private int $rewardValue;

    #[ORM\Column(length: 20, enumType: PromotionTargetEnum::class)]
    private PromotionTargetEnum $target;

    /** @var array<int, mixed> */
    #[ORM\Column(type: 'json')]
    private array $targetRefs = [];

    /** @var array<string, mixed> */
    #[ORM\Column(type: 'json')]
    private array $conditions = [];

    #[ORM\Column]
    private int $priority = 0;

    #[ORM\Column]
    private bool $stackable = false;

    #[ORM\Column(nullable: true)]
    private ?int $maxRedemptions = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxRedemptionsPerCustomer = null;

    #[ORM\Column]
    private int $redemptionsCount = 0;

    #[ORM\Column]
    private bool $isActive = true;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bannerTitle = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $bannerText = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBannerTitle(): ?string
    {
        return $this->bannerTitle;
    }

    public function setBannerTitle(?string $bannerTitle): void
    {
        $this->bannerTitle = $bannerTitle;
    }

    public function getBannerText(): ?string
    {
        return $this->bannerText;
    }

    public function setBannerText(?string $bannerText): void
    {
        $this->bannerText = $bannerText;
    }

    public function getWorkspaceId(): int
    {
        return $this->workspaceId;
    }

    public function setWorkspaceId(int $workspaceId): void
    {
        $this->workspaceId = $workspaceId;
    }

    public function getVenueId(): ?int
    {
        return $this->venueId;
    }

    public function setVenueId(?int $venueId): void
    {
        $this->venueId = $venueId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): PromotionTypeEnum
    {
        return $this->type;
    }

    public function setType(PromotionTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getRewardType(): RewardTypeEnum
    {
        return $this->rewardType;
    }

    public function setRewardType(RewardTypeEnum $rewardType): void
    {
        $this->rewardType = $rewardType;
    }

    public function getRewardValue(): int
    {
        return $this->rewardValue;
    }

    public function setRewardValue(int $rewardValue): void
    {
        $this->rewardValue = $rewardValue;
    }

    public function getTarget(): PromotionTargetEnum
    {
        return $this->target;
    }

    public function setTarget(PromotionTargetEnum $target): void
    {
        $this->target = $target;
    }

    /** @return array<int, mixed> */
    public function getTargetRefs(): array
    {
        return $this->targetRefs;
    }

    /** @param array<int, mixed> $targetRefs */
    public function setTargetRefs(array $targetRefs): void
    {
        $this->targetRefs = $targetRefs;
    }

    /** @return array<string, mixed> */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /** @param array<string, mixed> $conditions */
    public function setConditions(array $conditions): void
    {
        $this->conditions = $conditions;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function isStackable(): bool
    {
        return $this->stackable;
    }

    public function setStackable(bool $stackable): void
    {
        $this->stackable = $stackable;
    }

    public function getMaxRedemptions(): ?int
    {
        return $this->maxRedemptions;
    }

    public function setMaxRedemptions(?int $maxRedemptions): void
    {
        $this->maxRedemptions = $maxRedemptions;
    }

    public function getMaxRedemptionsPerCustomer(): ?int
    {
        return $this->maxRedemptionsPerCustomer;
    }

    public function setMaxRedemptionsPerCustomer(?int $maxRedemptionsPerCustomer): void
    {
        $this->maxRedemptionsPerCustomer = $maxRedemptionsPerCustomer;
    }

    public function getRedemptionsCount(): int
    {
        return $this->redemptionsCount;
    }

    public function setRedemptionsCount(int $redemptionsCount): void
    {
        $this->redemptionsCount = $redemptionsCount;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
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
