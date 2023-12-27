<?php

namespace App\Form;

use App\Entity\Recettes;
use App\Entity\Ingredients;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minLenght' => '2',
                    'maxLenght' => '50'
                ],
                'label' => 'NOM',
                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
    
                ])
                
            ->add('time', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => '1',
                    'max' => '1440'
                ],

                'label' => 'Temps (en minutes)',
                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],

                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(1441)
                ]

                ])

            ->add('nbPeople', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => '1',
                    'max' => '49'
                ],

                'label' => 'Nombre de Personne',
                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],

                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(50)
                ]
                ])

            ->add('difficulty' , RangeType::class, [
                'attr' => [
                    'class' => 'form-range',
                    'min' => '1',
                    'max' => '5'
                ],

                'label' => 'Difficulté Rencontré',
                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],

                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(6)
                ]

                ])

            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => '1',
                    'max' => '49'
                ],

                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],

                'constraints' => [
                    new Assert\NotBlank(),
                ]

                ])

            ->add('price', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control mt-4',
                ],
                'label' => 'PRIX',
                'label_attr' => [
                    'class' => 'form_label mt-4',
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(1001)
                ]
            ])

            ->add('isFavorite',  CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label' => 'Favorite?',
                'label_attr' => [
                    'class' => 'form-check-label',
                ],
                'required' => false
            ])


            ->add('ListeIngredients', EntityType::class, [
                'class' => Ingredients::class,
                'attr' => [
                    'class' => 'form-control mt-4',
                ],
                'mapped' => false,
                
                'choice_label' => function (Ingredients $ingredients): string {
                    return $ingredients->getName();
                   

                }
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ],
                'label' => 'Créer une Recette'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recettes::class,
        ]);
    }
}
