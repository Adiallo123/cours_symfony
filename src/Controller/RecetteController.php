<?php

namespace App\Controller;

use App\Entity\Recettes;
use App\Form\RecetteType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\RecettesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RecetteController extends AbstractController
{

    /**
     * This function display all recipes
     *
     * @param RecettesRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/recette', name: 'app_recette', methods:['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(RecettesRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
            $recettes = $paginator->paginate(
                $repository->findBy(['user' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10 /*limit per page*/
        );

        return $this->render('pages/recette/index.html.twig', [
            'Recettes' => $recettes]);
    }

    /**
     * Cette fonction permet de créer une nouvelle recette
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return response
     */
    #[Route('/recette/nouvelle', name:'recette.new', methods:['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $manager): response
    {
        $recettes = new Recettes();
        $form = $this->createForm(RecetteType::class , $recettes);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $recettes = $form->getData();
            $recettes->setUser($this->getUser());
            
            //dd($recettes);

            $manager->persist($recettes);
            $manager->flush();

            $this->addFlash(
                'success',
                'Les Recettes ont été ajouté avec sucess!'
            );
            return $this->redirectToRoute('app_recette');
        }

        return $this->render('pages/recette/new.html.twig', [
            'form' => $form
        ]);
    }
    
     
    #[Route('/recette/edition/{id}', name:'recette.edit', methods:['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER') and user === recettes.getUser()")]
    public function edit(Recettes $recettes , Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(RecetteType::class , $recettes);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $recettes = $form->getData();
            //dd($recettes);

            $manager->persist($recettes);
            $manager->flush();

            $this->addFlash(
                'success',
                'Les Recettes ont été modifié avec sucess!'
            );
            return $this->redirectToRoute('app_recette');
        }

        return $this->render('pages/recette/edit.html.twig', [
            'form' => $form
        ]);

    }


    #[Route('/recette/suppression/{id}', name:'recette.delete', methods:['GET'])]
    
    public function delete(Recettes $recettes, EntityManagerInterface $manager): Response
    {
        $manager->remove($recettes);
           $manager->flush();

            $this->addFlash(
            'success',
            'Votre recette à été supprimé avec succès !'
        );

          return $this->redirectToRoute('app_recette');

        
    }
}