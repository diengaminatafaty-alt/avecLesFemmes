<?php

namespace App\DTO;

use App\Entity\ModePayement;

class MembreDTO
{
    public function __construct(
        public readonly string $nom,
        public readonly string $tel,
        public readonly string $fonction,
        public readonly string $mode,
        public readonly int $montant,
    ) {
    }

    public static function fromParticipation(ModePayement $participation): self
    {
        $membre = $participation->getRole();

        return new self(
            (string) $membre?->getNom(),
            (string) $membre?->getTel(),
            (string) $membre?->getFonction(),
            $participation->isLibre() ? 'Montant libre' : 'Montant fixe',
            (int) $participation->getMontantChoisi()
        );
    }
}