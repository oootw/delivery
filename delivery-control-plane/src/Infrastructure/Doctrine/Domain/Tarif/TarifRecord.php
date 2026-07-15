<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Tarif;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cp_tarif')]
#[ORM\UniqueConstraint(name: 'uniq_cp_tarif_code', columns: ['code'])]
class TarifRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private string $code;

    #[ORM\Column(length: 128)]
    private string $name;

    #[ORM\Column(length: 1000)]
    private string $description;

    #[ORM\Column]
    private int $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }
}

