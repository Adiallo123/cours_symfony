<?php

namespace App\Form;

use App\Entity\Ingredients;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class IngredientType extends AbstractType
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
                    new Assert\LessThan(200)
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ],
                'label' => 'Créer un Ingredient'
            ])
            ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredients::class,
        ]);
    }
}
