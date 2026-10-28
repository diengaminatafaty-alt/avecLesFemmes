<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateSeanceAt = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    private ?Campagne $campagne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSeanceAt(): ?\DateTime
    {
        return $this->dateSeanceAt;
    }

    public function setDateSeanceAt(\DateTime $dateSeanceAt): static
    {
        $this->dateSeanceAt = $dateSeanceAt;

        return $this;
    }

    public function getCampagne(): ?Campagne
    {
        return $this->campagne;
    }

    public function setCampagne(?Campagne $campagne): static
    {
        $this->campagne = $campagne;

        return $this;
    }
}
