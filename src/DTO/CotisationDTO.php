<?php

namespace App\DTO;

use App\Entity\Cotisation;
use App\Enum\SituationCotisation;

class CotisationDTO
{
    public function __construct(
        public readonly string $membre,
        public readonly string $situation,
        public readonly int $montantEpargne,
        public readonly int $contributionCaisse,
    ) {
    }

    public static function fromEntity(Cotisation $cotisation): self
    {
        $situation = match ($cotisation->getSituation()) {
            SituationCotisation::PRESENT => 'Présent',
            SituationCotisation::ABSENT_REPRESENTE => 'Absent (argent envoyé)',
            SituationCotisation::ABSENT_NON_PAYE => 'Absent (non payé)',
            default => '-',
        };

        return new self(
            (string) $cotisation->getMembre()?->getNom(),
            $situation,
            (int) $cotisation->getMontantEpargne(),
            (int) $cotisation->getContributionCaisse()
        );
    }
}