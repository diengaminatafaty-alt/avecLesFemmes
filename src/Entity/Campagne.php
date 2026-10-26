<?php

namespace App\Entity;

use App\Repository\CampagneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
class Campagne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateDebutAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateFinAt = null;

    #[ORM\Column]
    private ?int $montant = null;

    /**
     * @var Collection<int, ModePayement>
     */
    #[ORM\OneToMany(targetEntity: ModePayement::class, mappedBy: 'campagne')]
    private Collection $modePayements;

    public function __construct()
    {
        $this->modePayements = new ArrayCollection();
    }

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

    public function getDateDebutAt(): ?\DateTime
    {
        return $this->dateDebutAt;
    }

    public function setDateDebutAt(\DateTime $dateDebutAt): static
    {
        $this->dateDebutAt = $dateDebutAt;

        return $this;
    }

    public function getDateFinAt(): ?\DateTime
    {
        return $this->dateFinAt;
    }

    public function setDateFinAt(\DateTime $dateFinAt): static
    {
        $this->dateFinAt = $dateFinAt;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * @return Collection<int, ModePayement>
     */
    public function getModePayements(): Collection
    {
        return $this->modePayements;
    }

    public function addModePayement(ModePayement $modePayement): static
    {
        if (!$this->modePayements->contains($modePayement)) {
            $this->modePayements->add($modePayement);
            $modePayement->setCampagne($this);
        }

        return $this;
    }

    public function removeModePayement(ModePayement $modePayement): static
    {
        if ($this->modePayements->removeElement($modePayement)) {
            // set the owning side to null (unless already changed)
            if ($modePayement->getCampagne() === $this) {
                $modePayement->setCampagne(null);
            }
        }

        return $this;
    }
}
