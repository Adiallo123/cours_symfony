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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserController extends AbstractController
{
    
    
    #[Route('/user/edition/{id}', name: 'user.edit', methods:['GET', 'POST'])]
    public function index(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {

        if(!$this->getUser())
        {
            return $this->redirectToRoute('security.login');
        }

        if($this->getUser() !== $user)
        {
            return $this->redirectToRoute('app_recette');
        }

        $form = $this->createForm(UserType::Class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($hasher->isPasswordValid($user, $form->getData()->getPlainPassword()))
            {
                $user = $form->getData();
                $manager->persist($user);
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

    #[Route('/user/edition-password/{id}', name:'user.edit.password', methods:['GET', 'POST'])]
    public function editPassword(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher):Response
    {
        $form = $this->createForm(UserPasswordType:: Class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            if($hasher->isPasswordValid($user, $form->getData()->getPlainPassword()))
            {
                $user->setPassword(
                    $hasher->hashPassword(
                        $user,
                        $form->getData()->getNewPassword()
                    )
                );

                $manager->persist($user);
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
