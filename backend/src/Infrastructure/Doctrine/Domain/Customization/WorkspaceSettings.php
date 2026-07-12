<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Customization;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkspaceSettingsRepository::class)]
#[ORM\Table(name: 'workspace_settings')]
#[ORM\UniqueConstraint(name: 'uniq_workspace_settings', columns: ['workspace_id'])]
class WorkspaceSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $workspaceId;

    /** @var array<string, bool|int|string> */
    #[ORM\Column(name: 'setting_values', type: 'json')]
    private array $values = [];

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

    /**
     * @return array<string, bool|int|string>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array<string, bool|int|string> $values
     */
    public function setValues(array $values): void
    {
        $this->values = $values;
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
