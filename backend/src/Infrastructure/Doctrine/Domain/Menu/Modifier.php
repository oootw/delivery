<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Menu;

use App\Infrastructure\Doctrine\Domain\Menu\ModifierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModifierRepository::class)]
#[ORM\Table(name: 'menu_modifier')]
#[ORM\UniqueConstraint(name: 'uniq_modifier_venue_external', columns: ['venue_id', 'external_id'])]
#[ORM\Index(name: 'idx_modifier_group', columns: ['modifier_group_external_id'])]
class Modifier
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
    private string $modifierGroupExternalId;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private int $priceKopecks;

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

    public function setModifierGroupExternalId(string $modifierGroupExternalId): void
    {
        $this->modifierGroupExternalId = $modifierGroupExternalId;
    }

    public function getModifierGroupExternalId(): string
    {
        return $this->modifierGroupExternalId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPriceKopecks(int $priceKopecks): void
    {
        $this->priceKopecks = $priceKopecks;
    }

    public function getPriceKopecks(): int
    {
        return $this->priceKopecks;
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
