<?php

namespace App\Service;

use App\Repository\CampagneRepository;
use App\Repository\GroupementRepository;
use App\DTO\GroupementDTO;
use App\DTO\CampagneDTO;
use App\Entity\Campagne;
use App\Entity\Groupement;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroupementService
{
    public function __construct(
        private GroupementRepository $groupementRepository,
        private CampagneRepository $campagneRepository,
    ) {
    }

    /**
     * @return GroupementDTO[]
     */
    public function getListe(): array
    {
        return array_map(
            fn (Groupement $groupement) => GroupementDTO::fromEntity($groupement),
            $this->groupementRepository->findAllWithExercices()
        );
    }

    /**
     * @return array{groupement: GroupementDTO, campagnes: CampagneDTO[]}
     */
    public function getDetail(int $id): array
    {
        $groupement = $this->groupementRepository->find($id);
        if (null === $groupement) {
            throw new NotFoundHttpException('Groupement introuvable.');
        }

        return [
            'groupement' => GroupementDTO::fromEntity($groupement),
            'campagnes' => array_map(
                fn (Campagne $campagne) => CampagneDTO::fromEntity($campagne),
                $this->campagneRepository->findByGroupement($groupement)
            ),
        ];
    }
}