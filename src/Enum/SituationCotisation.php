<?php

namespace App\Enum;

enum SituationCotisation: string
{
    case PRESENT = 'PRESENT';
    case ABSENT_REPRESENTE = 'ABSENT_REPRESENTE';
    case ABSENT_NON_PAYE = 'ABSENT_NON_PAYE';
}