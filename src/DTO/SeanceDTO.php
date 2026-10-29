<?php

namespace App\DTO;

use App\Entity\Seance;

class SeanceDTO
{
    /**
     * @param CotisationDTO[] $cotisations
     * @param AmendeDTO[]     $amendes
     */
    public function __construct(
        public readonly int $id,
        public readonly string $date,
        public readonly int $totalCollecte,
        public readonly int $totalAmendes,
        public readonly int $totalContributionsCaisse,
        public readonly array $cotisations,
        public readonly array $amendes,
    ) {
    }

    public static function fromEntity(Seance $seance): self
    {
        $cotisations = array_values(array_map(
            fn ($cotisation) => CotisationDTO::fromEntity($cotisation),
            $seance->getCotisations()->toArray()
        ));
        $amendes = array_values(array_map(
            fn ($amende) => AmendeDTO::fromEntity($amende),
            $seance->getAmendes()->toArray()
        ));

        $totalEpargne = array_sum(array_map(fn (CotisationDTO $c) => $c->montantEpargne, $cotisations));
        $totalContributions = array_sum(array_map(fn (CotisationDTO $c) => $c->contributionCaisse, $cotisations));
        $totalAmendes = array_sum(array_map(fn (AmendeDTO $a) => $a->total, $amendes));

        return new self(
            (int) $seance->getId(),
            $seance->getDateSeanceAt()?->format('d/m/Y') ?? '-',
            $totalEpargne + $totalContributions + $totalAmendes,
            $totalAmendes,
            $totalContributions,
            $cotisations,
            $amendes
        );
    }
}