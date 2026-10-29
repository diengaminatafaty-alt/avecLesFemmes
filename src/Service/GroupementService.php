<?php

namespace App\Service;

use App\Repository\CampagneRepository;
use App\Repository\GroupementRepository;

class GroupementService
{
    public function __construct(
        private GroupementRepository $groupementRepository,
        private CampagneRepository $campagneRepository,
    ) {
    }
}