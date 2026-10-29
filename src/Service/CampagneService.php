<?php
 namespace App\Service;

 use App\Repository\CampagneRepository;
 use App\Repository\SeanceRepository;

class CampagneService
{
    public function __construct(
        private CampagneRepository $campagneRepository,
        private SeanceRepository $seanceRepository,
    ) {
    }
}