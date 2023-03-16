<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
// use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;
use Doctrine\Persistence\ObjectManager;



class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
     
    }
 
    public function load(ObjectManager $manager): void
    {
        //Pour générer des fixtures (aléatoirement plusieurs ingrédients) en bd
        for ($i=0; $i < 50; $i++) { 

            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                       ->setPrice(mt_rand(0, 100));

            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}
