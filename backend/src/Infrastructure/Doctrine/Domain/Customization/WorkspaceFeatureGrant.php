<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Customization;

use App\Shared\Enum\Feature\FeatureCodeEnum;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkspaceFeatureGrantRepository::class)]
#[ORM\Table(name: 'workspace_feature_grant')]
#[ORM\UniqueConstraint(name: 'uniq_workspace_feature_grant', columns: ['workspace_id', 'feature'])]
class WorkspaceFeatureGrant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    #[ORM\Column(length: 32, enumType: FeatureCodeEnum::class)]
    private FeatureCodeEnum $feature;

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

    public function getFeature(): FeatureCodeEnum
    {
        return $this->feature;
    }

    public function setFeature(FeatureCodeEnum $feature): void
    {
        $this->feature = $feature;
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
