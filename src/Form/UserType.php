<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('fullname', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minLenght' => '2',
                'maxLenght' => '50'
            ],
            'label' => 'Nom / Prenom',
            'label_attr' => [
                'class' => 'form_label mt-4',
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' => 50])
            ]
            ])

        ->add('pseudo', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minLenght' => '2',
                'maxLenght' => '50'
            ],
            'label' => 'Pseudo',
            'label_attr' => [
                'class' => 'form_label mt-4',
            ],
            'constraints' => [
                new Assert\Length(['min' => 2, 'max' => 50])
            ]
            ])

            ->add('plainPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Mot de Passe',
                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],
            ])
    
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4',
            ],
            'label' => 'Submit'
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
