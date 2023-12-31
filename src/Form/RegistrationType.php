<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationType extends AbstractType
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
                'label' => 'Pseudo (Facultatif)',
                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
    
                ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minLenght' => '2',
                    'maxLenght' => '180'
                ],
                'label' => 'Adresse email',
                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
                ])

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,

                'first_options'  => [
                    'label' => 'Mot de Passe',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ],

                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],

                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ],

                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],

                'invalid_message' => 'Les deux mots de passe de correspondent pas.',
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ],
                'label' => 'S\' Inscription'
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
