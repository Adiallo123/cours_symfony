<?php

namespace  App\Controller;

use App\Repository\RecettesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', 'home.index', methods:['GET'])]

    public function index(
        RecettesRepository $recettesRepository
    ): Response
    {
        return $this->render('pages/home.html.twig', [
            'recette' => $recettesRepository->findPublicRecette(3)
        ]
        );
    }

}


?>