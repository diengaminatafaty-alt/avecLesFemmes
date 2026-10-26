<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $tel = null;

    #[ORM\Column(length: 150)]
    private ?string $adresse = null;

    #[ORM\Column(length: 150)]
    private ?string $login = null;

    #[ORM\Column(length: 15)]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $fonction = null;

    /**
     * @var Collection<int, ModePayement>
     */
    #[ORM\OneToMany(targetEntity: ModePayement::class, mappedBy: 'role')]
    private Collection $modePayements;

    #[ORM\ManyToOne(inversedBy: 'roles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $groupement = null;

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

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): static
    {
        $this->fonction = $fonction;

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
            $modePayement->setRole($this);
        }

        return $this;
    }

    public function removeModePayement(ModePayement $modePayement): static
    {
        if ($this->modePayements->removeElement($modePayement)) {
            // set the owning side to null (unless already changed)
            if ($modePayement->getRole() === $this) {
                $modePayement->setRole(null);
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
}
