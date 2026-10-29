<?php
// src/Enum/StatutExercice.php

namespace App\Enum;

enum StatutExercice: string
{
    case EN_COURS = 'EN_COURS';
    case CLOTURE = 'CLOTURE';

    public function label(): string
    {
        return match ($this) {
            self::EN_COURS => 'En cours',
            self::CLOTURE => 'Clôturé',
        };
    }
}