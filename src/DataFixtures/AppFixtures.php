<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ingredients;
use App\Entity\Mark;
use App\Entity\Recettes;
use App\Entity\User;
use Faker\Generator;
use Faker\Factory;

class AppFixtures extends Fixture
{

    /***
     * @var Generator
     * 
     */
     
     private Generator $faker;

     

     public function __construct( )
     {
        $this->faker = Factory::create('fr_FR');
       
     }

    public function load(ObjectManager $manager): void
    {

         //les utilisateurs
         $arrayUser = [];
         for ($i=0; $i <10 ; $i++) 
         { 
            $user = new User();
            $user->setFullname($this->faker->name())
                ->setPseudo($this->faker->firstName())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
                
            $arrayUser[] = $user;
            $manager->persist($user);
 
         }
 
        //les ingredients
        $arrayIngredients = [];
        for($i=1; $i<=25; $i++)
        {
            $ingredients = new Ingredients();
            $ingredients->setName($this->faker->word())
            ->setPrice(mt_rand(0, 100))
            ->setUser($arrayUser[mt_rand(0, count($arrayUser) -1)]);


            $arrayIngredients[] = $ingredients;
            $manager->persist($ingredients);
        }

        //les recettes
        $arrayRecette = [];
        for($j=1; $j<20; $j++)
        {
            $recettes = new Recettes();
            $recettes->setName($this->faker->word())
                ->setTime(mt_rand(0, 1) == 1 ? mt_rand(1, 1440) : null)
                ->setnbPeople(mt_rand(0, 1) == 1 ? mt_rand(1, 49) : null)
                ->setDifficulty(mt_rand(0, 1) == 1 ? mt_rand(1, 5) : null)
                ->setDescription($this->faker->text(255))
                ->setPrice(mt_rand(0, 1) == 1 ? mt_rand(1, 1000) : 0)
                ->setIsFavorite(mt_rand(0, 1) == 1 ? true : false)
                ->setIsPublic(mt_rand(0, 1) == 1 ? true :false)
                ->setUser($arrayUser[mt_rand(0, count($arrayUser) -1)]);
                

            for($k=1; $k< mt_rand(5, 15); $k++)
            {
                $recettes->addListeIngredient($arrayIngredients[mt_rand(0, count($arrayIngredients) -1)]);

                $arrayRecette[] = $recettes;
                $manager->persist($recettes);

            }

            
        }

        //mark
        foreach($arrayRecette as $recette)
        {
            for ($i=0; $i < mt_rand(0, 4); $i++) { 
                $mark = new Mark();
                $mark->setMark(mt_rand(1, 5))
                    ->setUser($arrayUser[mt_rand(0, count($arrayUser) -1)])
                    ->setRecette($recette);

                $manager->persist($mark);
            }
        }

       
        $manager->flush();

       
    }
}