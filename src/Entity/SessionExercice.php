<?php

namespace App\Entity;

use App\Repository\SessionExerciceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionExerciceRepository::class)]
class SessionExercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?User $utilisateur = null;

    #[ORM\OneToOne(inversedBy: 'session', cascade: ['persist', 'remove'])]
    private ?ExerciceRespiration $exerciceRespiration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTime $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTime $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getUtilisateur(): ?user
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?user $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getExerciceRespiration(): ?ExerciceRespiration
    {
        return $this->exerciceRespiration;
    }

    public function setExerciceRespiration(?ExerciceRespiration $exerciceRespiration): static
    {
        $this->exerciceRespiration = $exerciceRespiration;

        return $this;
    }
}
