<?php

namespace App\Entity;

use App\Repository\AmendeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AmendeRepository::class)]
class Amende
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'amendes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seance $seance = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $membre = null;

    #[ORM\Column]
    private ?int $nombreJours = null;

    #[ORM\Column]
    private ?int $montantParJour = null;

    #[ORM\Column]
    private ?bool $isPayee = null;

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

    public function getNombreJours(): ?int
    {
        return $this->nombreJours;
    }

    public function setNombreJours(int $nombreJours): static
    {
        $this->nombreJours = $nombreJours;

        return $this;
    }

    public function getMontantParJour(): ?int
    {
        return $this->montantParJour;
    }

    public function setMontantParJour(int $montantParJour): static
    {
        $this->montantParJour = $montantParJour;

        return $this;
    }

    public function isPayee(): ?bool
    {
        return $this->isPayee;
    }

    public function setIsPayee(bool $isPayee): static
    {
        $this->isPayee = $isPayee;

        return $this;
    }
}
