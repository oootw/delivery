<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Menu;

use App\Infrastructure\Doctrine\Domain\Menu\ComboRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComboRepository::class)]
#[ORM\Table(name: 'menu_combo')]
#[ORM\UniqueConstraint(name: 'uniq_menu_combo_venue_external', columns: ['venue_id', 'external_id'])]
#[ORM\Index(name: 'idx_menu_combo_venue', columns: ['venue_id'])]
class Combo
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

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(length: 32)]
    private string $discountType;

    #[ORM\Column]
    private int $discountValue;

    /** @var array<int, array<string, mixed>> */
    #[ORM\Column(type: Types::JSON)]
    private array $items = [];

    #[ORM\Column]
    private int $position;

    #[ORM\Column]
    private bool $isAvailable;

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

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDiscountType(string $discountType): void
    {
        $this->discountType = $discountType;
    }

    public function getDiscountType(): string
    {
        return $this->discountType;
    }

    public function setDiscountValue(int $discountValue): void
    {
        $this->discountValue = $discountValue;
    }

    public function getDiscountValue(): int
    {
        return $this->discountValue;
    }

    /** @param array<int, array<string, mixed>> $items */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /** @return array<int, array<string, mixed>> */
    public function getItems(): array
    {
        return $this->items;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setIsAvailable(bool $isAvailable): void
    {
        $this->isAvailable = $isAvailable;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
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
