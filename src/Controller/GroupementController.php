<?php

namespace App\Controller;

use App\Service\GroupementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GroupementController extends AbstractController
{
    public function __construct(private GroupementService $groupementService)
    {
    }

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->redirectToRoute('app_groupement_index');
    }

    #[Route('/groupements', name: 'app_groupement_index')]
    public function index(): Response
    {
        return $this->render('groupement/index.html.twig', [
            'dataGroupements' => $this->groupementService->getListe(),
        ]);
    }

    #[Route('/groupements/{id}', name: 'app_groupement_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        return $this->render('groupement/show.html.twig', $this->groupementService->getDetail($id));
    }
}