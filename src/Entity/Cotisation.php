<?php

namespace App\Entity;

use App\Repository\CotisationRepository;
use App\Enum\SituationCotisation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CotisationRepository::class)]
class Cotisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cotisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seance $seance = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $membre = null;

    #[ORM\Column]
    private ?int $montantEpargne = null;

    #[ORM\Column]
    private ?int $contributionCaisse = null;

    #[ORM\Column(length: 30, enumType: SituationCotisation::class)]
    private ?SituationCotisation $situation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): static
    {
        $this->seance = $seance;

        return $this;
    }

    public function getMembre(): ?Role
    {
        return $this->membre;
    }

    public function setMembre(?Role $membre): static
    {
        $this->membre = $membre;

        return $this;
    }

    public function getMontantEpargne(): ?int
    {
        return $this->montantEpargne;
    }

    public function setMontantEpargne(int $montantEpargne): static
    {
        $this->montantEpargne = $montantEpargne;

        return $this;
    }

    public function getContributionCaisse(): ?int
    {
        return $this->contributionCaisse;
    }

    public function setContributionCaisse(int $contributionCaisse): static
    {
        $this->contributionCaisse = $contributionCaisse;

        return $this;
    }

    public function getSituation(): ?SituationCotisation
    {
        return $this->situation;
    }

    public function setSituation(SituationCotisation $situation): static
    {
        $this->situation = $situation;

        return $this;
    }
}
