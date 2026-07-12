<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Menu;

use App\Infrastructure\Doctrine\Domain\Menu\MenuItemNutritionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuItemNutritionRepository::class)]
#[ORM\Table(name: 'menu_item_nutrition')]
#[ORM\UniqueConstraint(name: 'uniq_menu_item_nutrition_venue_item', columns: ['venue_id', 'item_external_id'])]
class MenuItemNutrition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $venueId;

    #[ORM\Column(length: 255)]
    private string $itemExternalId;

    /** @var array<string, mixed> */
    #[ORM\Column(type: Types::JSON)]
    private array $nutrition = [];

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

    public function setItemExternalId(string $itemExternalId): void
    {
        $this->itemExternalId = $itemExternalId;
    }

    public function getItemExternalId(): string
    {
        return $this->itemExternalId;
    }

    /** @param array<string, mixed> $nutrition */
    public function setNutrition(array $nutrition): void
    {
        $this->nutrition = $nutrition;
    }

    /** @return array<string, mixed> */
    public function getNutrition(): array
    {
        return $this->nutrition;
    }
}
