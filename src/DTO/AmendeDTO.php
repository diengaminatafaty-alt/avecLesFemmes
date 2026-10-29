<?php

namespace App\DTO;

use App\Entity\Amende;

class AmendeDTO
{
    public function __construct(
        public readonly string $membre,
        public readonly int $nombreJours,
        public readonly int $montantParJour,
        public readonly int $total,
        public readonly string $statut,
    ) {
    }

    public static function fromEntity(Amende $amende): self
    {
        return new self(
            (string) $amende->getMembre()?->getNom(),
            (int) $amende->getNombreJours(),
            (int) $amende->getMontantParJour(),
            $amende->getTotal(),
            $amende->isPayee() ? 'Payée' : 'Non payée'
        );
    }
}