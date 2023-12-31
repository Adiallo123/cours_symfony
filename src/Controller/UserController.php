<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserController extends AbstractController
{
    
    #[Security("is_granted('ROLE_USER') and user === utilisateur")]
    #[Route('/user/edition/{id}', name: 'user.edit', methods:['GET', 'POST'])]
    public function index(User $utilisateur, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {

       /* if(!$this->getUser())
        {
            return $this->redirectToRoute('security.login');
        }

        if($this->getUser() !== $user)
        {
            return $this->redirectToRoute('app_recette');
        }*/

        $form = $this->createForm(UserType::class, $utilisateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($hasher->isPasswordValid($utilisateur, $form->getData()->getPlainPassword()))
            {
                $user = $form->getData();
                $manager->persist($utilisateur);
                $manager->flush();
    
                $this->addFlash(
                        'success',
                        'Votre profile a bien été modifier!'
                );
                return $this->redirectToRoute('app_recette');
            }
            else{
                $this->addFlash(
                    'warning',
                    'le mot de passe renseigner est incorrect.'
                );
            }
        }
        return $this->render('pages/user/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Security("is_granted('ROLE_USER') and user === utilisateur")]
    #[Route('/user/edition-password/{id}', name:'user.edit.password', methods:['GET', 'POST'])]
    public function editPassword(User $utilisateur, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher):Response
    {
        $form = $this->createForm(UserPasswordType:: class, $utilisateur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            if($hasher->isPasswordValid($utilisateur, $form->getData()->getPlainPassword()))
            {
                $utilisateur->setPassword(
                    $hasher->hashPassword(
                        $utilisateur,
                        $form->getData()->getNewPassword()
                    )
                );

                $manager->persist($utilisateur);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre mot de passe a bien été modifier!'
                );

                return $this->redirectToRoute('app_recette');

            }else{
                $this->addFlash(
                    'warning',
                    'les deux mots de passse de sont pas identique'
                );
            }
        }

        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form,
        ]);
    }
}
