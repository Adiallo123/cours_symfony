<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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

        ->add('newPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Nouveau Mot de Passe',
                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],
            ])
    
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4',
            ],
            'label' => 'Changer de mot de passe'
        ])
    ;
    }

}
