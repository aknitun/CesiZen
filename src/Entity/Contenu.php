<?php

namespace App\Entity;

use App\Repository\ContenuRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContenuRepository::class)]
class Contenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: 'text')]
    private ?string $corps = null;

    #[ORM\Column]
    private ?bool $publier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getCorps(): ?string
    {
        return $this->corps;
    }

    public function setCorps(string $corps): static
    {
        $this->corps = $corps;

        return $this;
    }

    public function isPublier(): ?bool
    {
        return $this->publier;
    }

    public function setPublier(bool $publier): static
    {
        $this->publier = $publier;

        return $this;
    }
}
