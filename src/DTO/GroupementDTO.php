<?php

namespace App\DTO;

use App\Entity\Groupement;
use App\Enum\StatutExercice;

class GroupementDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $nom,
        public readonly string $adresse,
        public readonly string $tel,
        public readonly int $nombreExercices,
        public readonly ?string $statutExercice,
        public readonly ?string $exerciceDepuis,
        public readonly string $exerciceEnCours,
    ) {
    }

    public static function fromEntity(Groupement $groupement): self
    {
        $statut = null;
        $depuis = null;
        $periode = 'Aucun exercice en cours';

        // Résolution de l'exercice en cours : c'est le DTO qui s'en charge, pas Twig
        foreach ($groupement->getExercices() as $exercice) {
            if ($exercice->getStatut() === StatutExercice::EN_COURS) {
                $statut = StatutExercice::EN_COURS->label();
                $depuis = $exercice->getDateDebutAt()?->format('d/m/Y');
                $periode = sprintf(
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
            (string) $groupement->getAdresse(),
            (string) $groupement->getTel(),
            $groupement->getExercices()->count(),
            $statut,
            $depuis,
            $periode
        );
    }
}