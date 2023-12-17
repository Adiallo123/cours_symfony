<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Form\IngredientType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\IngredientsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class IngredientController extends AbstractController
{

    /**
     *  this function display allgredients
     * @param IngredientsRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    #[Route('/ingredient', name: 'app_ingredient', methods:['GET'])]
    public function index(IngredientsRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $ingredients = $paginator->paginate(
            $pagination =  $repository->findAll(),
            $request->query->getInt('page', 1), 
            10 /*limit per page*/
        );

        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients' => $ingredients ]);
    }

    /**
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/ingredient/nouveau', name:'ingredient.new', methods:['GET', 'POST'])]
    public function new( Request $request, EntityManagerInterface $manager): Response
    {
        $ingredients = new Ingredients();
        $form = $this->createForm(IngredientType::class, $ingredients);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $ingredients = $form->getData();
           // dd($ingredients);
           $manager->persist($ingredients);
           $manager->flush();

            $this->addFlash(
            'success',
            'Votre ingrédient à été créé avec succès!'
        );

          return $this->redirectToRoute('app_ingredient');
        }

        return $this->render('pages/ingredient/new.html.twig', [
            'form' => $form
         ]);
    }
   
    #[Route('/ingredient/edition/{id}', name:'ingredient.edit', methods:['GET', 'POST'])]
    public function edit(Ingredients $ingredients , Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(IngredientType::class, $ingredients);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $ingredients = $form->getData();
           // dd($ingredients);
           $manager->persist($ingredients);
           $manager->flush();

            $this->addFlash(
            'success',
            'Votre ingrédient à été modifié avec succès!'
        );

          return $this->redirectToRoute('app_ingredient');
        }

        return $this->render('pages/ingredient/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/ingredient/suppression/{id}', name:'ingredient.delete', methods:['GET'])]
    public function delete(Ingredients $ingredients, EntityManagerInterface $manager): Response
    {
        $manager->remove($ingredients);
           $manager->flush();

            $this->addFlash(
            'success',
            'Votre ingrédient à été supprimé avec succès !'
        );

          return $this->redirectToRoute('app_ingredient');

        return $this->render('pages/ingredient/delete.html.twig', [
            'form' => $form
        ]);
    }
}
