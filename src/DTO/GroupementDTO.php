<?php

namespace App\DTO;

use App\Entity\Groupement;
use App\Enum\StatutExercice;

class GroupementDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $nom,
        public readonly string $exerciceEnCours,
    ) {
    }

    public static function fromEntity(Groupement $groupement): self
    {
        // Résolution de l'exercice en cours : c'est le DTO qui s'en charge, pas Twig
        $exerciceEnCours = 'Aucun exercice en cours';
        foreach ($groupement->getExercices() as $exercice) {
            if ($exercice->getStatut() === StatutExercice::EN_COURS) {
                $exerciceEnCours = sprintf(
                    'Du %s au %s',
                    $exercice->getDateDebutAt()?->format('d/m/Y') ?? '-',
                    $exercice->getDateFinAt()?->format('d/m/Y') ?? '-'
                );
                break;
            }
        }

        return new self(
            (int) $groupement->getId(),
            (string) $groupement->getNom(),
            $exerciceEnCours
        );
    }
}