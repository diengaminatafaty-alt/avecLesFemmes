<?php

namespace App\DTO;

use App\Entity\Campagne;
use App\Entity\Epargne;
use App\Entity\Tontine;

class CampagneDTO
{
    private const JOURS = [
        1 => 'Lundi',
        2 => 'Mardi',
        3 => 'Mercredi',
        4 => 'Jeudi',
        5 => 'Vendredi',
        6 => 'Samedi',
        7 => 'Dimanche',
    ];

    public function __construct(
        public readonly int $id,
        public readonly string $nom,
        public readonly string $type,
        public readonly string $periodicite,
        public readonly string $jourRencontre,
        public readonly string $dateDebut,
        public readonly string $dateFin,
        public readonly int $montant,
    ) {
    }

    public static function fromEntity(Campagne $campagne): self
    {
        $type = match (true) {
            $campagne instanceof Tontine => 'Tontine',
            $campagne instanceof Epargne => 'Épargne',
            default => 'Campagne',
        };

        return new self(
            (int) $campagne->getId(),
            (string) $campagne->getNom(),
            $type,
            ucfirst(strtolower($campagne->getPeriodicite()?->name ?? '')),
            self::JOURS[$campagne->getJourRencontre()] ?? '-',
            $campagne->getDateDebutAt()?->format('d/m/Y') ?? '-',
            $campagne->getDateFinAt()?->format('d/m/Y') ?? '-',
            (int) $campagne->getMontant()
        );
    }
}