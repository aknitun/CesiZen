<?php

namespace App\Entity;

use App\Repository\ExerciceRespirationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciceRespirationRepository::class)]
class ExerciceRespiration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $dureeInspiration = null;

    #[ORM\Column]
    private ?int $dureeApnee = null;

    #[ORM\Column]
    private ?int $dureeExpiration = null;

    #[ORM\Column]
    private ?bool $publier = null;

    #[ORM\OneToOne(mappedBy: 'exerciceRespiration', cascade: ['persist', 'remove'])]
    private ?SessionExercice $session = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDureeInspiration(): ?int
    {
        return $this->dureeInspiration;
    }

    public function setDureeInspiration(int $dureeInspiration): static
    {
        $this->dureeInspiration = $dureeInspiration;

        return $this;
    }

    public function getDureeApnee(): ?int
    {
        return $this->dureeApnee;
    }

    public function setDureeApnee(int $dureeApnee): static
    {
        $this->dureeApnee = $dureeApnee;

        return $this;
    }

    public function getDureeExpiration(): ?int
    {
        return $this->dureeExpiration;
    }

    public function setDureeExpiration(int $dureeExpiration): static
    {
        $this->dureeExpiration = $dureeExpiration;

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

    public function getSession(): ?SessionExercice
    {
        return $this->session;
    }

    public function setSession(?SessionExercice $session): static
    {
        // unset the owning side of the relation if necessary
        if ($session === null && $this->session !== null) {
            $this->session->setExerciceRespiration(null);
        }

        // set the owning side of the relation if necessary
        if ($session !== null && $session->getExerciceRespiration() !== $this) {
            $session->setExerciceRespiration($this);
        }

        $this->session = $session;

        return $this;
    }
}
