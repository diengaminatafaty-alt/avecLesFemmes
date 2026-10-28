<?php

namespace App\Entity;

use App\Enum\Periodicite;
use App\Repository\CampagneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'campagne' => Campagne::class,
    'tontine'  => Tontine::class,
    'epargne'  => Epargne::class,
])]
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

    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $groupement = null;

    #[ORM\Column(enumType: Periodicite::class)]
    private ?Periodicite $periodicite = null;

    #[ORM\Column]
    private ?int $jourRencontre = null;

    #[ORM\Column]
    private ?int $contributionCaissePresent = null;

    #[ORM\Column]
    private ?int $contributionCaisseAbsent = null;

    #[ORM\Column]
    private ?int $amendeJournaliere = null;

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

    public function getGroupement(): ?Groupement
    {
        return $this->groupement;
    }

    public function setGroupement(?Groupement $groupement): static
    {
        $this->groupement = $groupement;

        return $this;
    }

    public function getPeriodicite(): ?Periodicite
    {
        return $this->periodicite;
    }

    public function setPeriodicite(Periodicite $periodicite): static
    {
        $this->periodicite = $periodicite;

        return $this;
    }

    public function getJourRencontre(): ?int
    {
        return $this->jourRencontre;
    }

    public function setJourRencontre(int $jourRencontre): static
    {
        $this->jourRencontre = $jourRencontre;

        return $this;
    }

    public function getContributionCaissePresent(): ?int
    {
        return $this->contributionCaissePresent;
    }

    public function setContributionCaissePresent(int $contributionCaissePresent): static
    {
        $this->contributionCaissePresent = $contributionCaissePresent;

        return $this;
    }

    public function getContributionCaisseAbsent(): ?int
    {
        return $this->contributionCaisseAbsent;
    }

    public function setContributionCaisseAbsent(int $contributionCaisseAbsent): static
    {
        $this->contributionCaisseAbsent = $contributionCaisseAbsent;

        return $this;
    }

    public function getAmendeJournaliere(): ?int
    {
        return $this->amendeJournaliere;
    }

    public function setAmendeJournaliere(int $amendeJournaliere): static
    {
        $this->amendeJournaliere = $amendeJournaliere;

        return $this;
    }
}
