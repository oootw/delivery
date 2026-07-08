<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Menu;

use App\Infrastructure\Doctrine\Domain\Menu\ModifierGroupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModifierGroupRepository::class)]
#[ORM\Table(name: 'menu_modifier_group')]
#[ORM\UniqueConstraint(name: 'uniq_modifier_group_venue_external', columns: ['venue_id', 'external_id'])]
class ModifierGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $venueId;

    #[ORM\Column(length: 255)]
    private string $externalId;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private int $minSelection;

    #[ORM\Column]
    private int $maxSelection;

    #[ORM\Column]
    private bool $isArchived;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setVenueId(int $venueId): void
    {
        $this->venueId = $venueId;
    }

    public function getVenueId(): int
    {
        return $this->venueId;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setMinSelection(int $minSelection): void
    {
        $this->minSelection = $minSelection;
    }

    public function getMinSelection(): int
    {
        return $this->minSelection;
    }

    public function setMaxSelection(int $maxSelection): void
    {
        $this->maxSelection = $maxSelection;
    }

    public function getMaxSelection(): int
    {
        return $this->maxSelection;
    }

    public function setIsArchived(bool $isArchived): void
    {
        $this->isArchived = $isArchived;
    }

    public function isArchived(): bool
    {
        return $this->isArchived;
    }
}
