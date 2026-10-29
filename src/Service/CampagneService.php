<?php
 namespace App\Service;

 use App\Repository\CampagneRepository;
 use App\Repository\SeanceRepository;
 use App\DTO\CampagneDTO;
 use App\DTO\MembreDTO;
 use App\Entity\ModePayement;
 use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CampagneService
{
    public function __construct(
        private CampagneRepository $campagneRepository,
        private SeanceRepository $seanceRepository,
    ) {
    }

    /**
     * Détail d'une campagne avec ses membres participants.
     *
     * @return array{campagne: CampagneDTO, membres: MembreDTO[]}
     */
    public function getDetail(int $id): array
    {
        $campagne = $this->campagneRepository->findOneWithParticipants($id);
        if (null === $campagne) {
            throw new NotFoundHttpException('Campagne introuvable.');
        }

        return [
            'campagne' => CampagneDTO::fromEntity($campagne),
            'membres' => array_map(
                fn (ModePayement $participation) => MembreDTO::fromParticipation($participation),
                $campagne->getModePayements()->toArray()
            ),
        ];
    }
}