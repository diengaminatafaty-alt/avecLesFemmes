<?php

namespace App\Controller;

use App\Service\CampagneService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CampagneController extends AbstractController
{
    public function __construct(private CampagneService $campagneService)
    {
    }

    #[Route('/campagnes/{id}', name: 'app_campagne_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        return $this->render('campagne/show.html.twig', $this->campagneService->getDetail($id));
    }

    #[Route('/campagnes/{id}/seances', name: 'app_campagne_seances', requirements: ['id' => '\d+'])]
    public function seances(int $id): Response
    {
        return $this->render('campagne/seances.html.twig', $this->campagneService->getSeances($id));
    }
}