<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Wishes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function Symfony\Component\Clock\now;
use Faker\Factory;

class WishesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 20 products! Bam!
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $wish = new Wishes();
            $wish->setTitle($faker->word());
            $wish->setDescription($faker->sentence(15));
            $wish->setAuthor($faker->name());
            $wish->setCreatedAt(\DateTimeImmutable::createFromFormat('U', now()->format('U')));
            $wish->setIsPublished($faker->boolean(50));
            $manager->persist($wish);
        }

        $manager->flush();
    }
}
