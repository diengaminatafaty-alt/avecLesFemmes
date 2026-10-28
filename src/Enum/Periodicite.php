<?php
// src/Enum/Periodicite.php

namespace App\Enum;

enum Periodicite: string
{
    case HEBDOMADAIRE = 'HEBDOMADAIRE';
    case BIMENSUELLE = 'BIMENSUELLE';
    case MENSUELLE = 'MENSUELLE';
    case QUINZAINE = 'QUINZAINE';
}