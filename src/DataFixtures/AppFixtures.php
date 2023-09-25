<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create($fakerLocale = 'fr_FR');
        
        for ($i=0; $i < 500; $i++) { 
            $book = new Book();
            $book->setTitle($faker->sentence(1))
                ->setDescription($faker->sentence(7))
                ->setSlug('slug-temporaire')
                ->setPages(203)
                ->setYear($faker->numberBetween(1950, 2023))
                ->setIsAvailable($faker->boolean())
                ;
            $manager->persist($book);
        }
        $manager->flush();
    }
}
