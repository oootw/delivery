<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Authorize;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cp_user')]
#[ORM\UniqueConstraint(name: 'uniq_cp_user_phone', columns: ['phone'])]
class UserRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private string $phone;

    #[ORM\Column(length: 128)]
    private string $name;

    #[ORM\Column]
    private bool $isAdmin = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }
}

