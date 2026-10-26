<?php

namespace App\Entity;

use App\Repository\PretRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PretRepository::class)]
class Pret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $datePretAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateRendementPrevuAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateRenduAt = null;

    #[ORM\Column]
    private ?int $interet = null;

    /**
     * @var Collection<int, Role>
     */
    #[ORM\OneToMany(targetEntity: Role::class, mappedBy: 'pret')]
    private Collection $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDatePretAt(): ?\DateTime
    {
        return $this->datePretAt;
    }

    public function setDatePretAt(\DateTime $datePretAt): static
    {
        $this->datePretAt = $datePretAt;

        return $this;
    }

    public function getDateRendementPrevuAt(): ?\DateTime
    {
        return $this->dateRendementPrevuAt;
    }

    public function setDateRendementPrevuAt(\DateTime $dateRendementPrevuAt): static
    {
        $this->dateRendementPrevuAt = $dateRendementPrevuAt;

        return $this;
    }

    public function getDateRenduAt(): ?\DateTime
    {
        return $this->dateRenduAt;
    }

    public function setDateRenduAt(\DateTime $dateRenduAt): static
    {
        $this->dateRenduAt = $dateRenduAt;

        return $this;
    }

    public function getInteret(): ?int
    {
        return $this->interet;
    }

    public function setInteret(int $interet): static
    {
        $this->interet = $interet;

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->setPret($this);
        }

        return $this;
    }

    public function removeRole(Role $role): static
    {
        if ($this->roles->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getPret() === $this) {
                $role->setPret(null);
            }
        }

        return $this;
    }
}
