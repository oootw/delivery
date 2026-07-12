<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Menu;

use App\Infrastructure\Doctrine\Domain\Menu\MenuItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuItemRepository::class)]
#[ORM\Table(name: 'menu_item')]
#[ORM\UniqueConstraint(name: 'uniq_menu_item_venue_external', columns: ['venue_id', 'external_id'])]
#[ORM\Index(name: 'idx_menu_item_venue', columns: ['venue_id'])]
class MenuItem
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
    private string $categoryExternalId;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column]
    private int $priceKopecks;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column]
    private bool $isAvailable;

    #[ORM\Column]
    private int $position;

    /** @var string[] */
    #[ORM\Column(type: Types::JSON)]
    private array $modifierGroupExternalIds = [];

    #[ORM\Column]
    private bool $isArchived;

    /** @var array<string, mixed>|null */
    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $posNutrition = null;

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

    public function setCategoryExternalId(string $categoryExternalId): void
    {
        $this->categoryExternalId = $categoryExternalId;
    }

    public function getCategoryExternalId(): string
    {
        return $this->categoryExternalId;
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

    public function setPriceKopecks(int $priceKopecks): void
    {
        $this->priceKopecks = $priceKopecks;
    }

    public function getPriceKopecks(): int
    {
        return $this->priceKopecks;
    }

    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setIsAvailable(bool $isAvailable): void
    {
        $this->isAvailable = $isAvailable;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    /** @param string[] $modifierGroupExternalIds */
    public function setModifierGroupExternalIds(array $modifierGroupExternalIds): void
    {
        $this->modifierGroupExternalIds = $modifierGroupExternalIds;
    }

    /** @return string[] */
    public function getModifierGroupExternalIds(): array
    {
        return $this->modifierGroupExternalIds;
    }

    public function setIsArchived(bool $isArchived): void
    {
        $this->isArchived = $isArchived;
    }

    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    /** @param array<string, mixed>|null $posNutrition */
    public function setPosNutrition(?array $posNutrition): void
    {
        $this->posNutrition = $posNutrition;
    }

    /** @return array<string, mixed>|null */
    public function getPosNutrition(): ?array
    {
        return $this->posNutrition;
    }
}
