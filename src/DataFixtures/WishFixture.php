<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WishFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // create 20 wishes! Bam!
        for ($i = 0; $i < 20; $i++) {
            $wish = new Wish();
            $wish->setTitle($faker->word(5))
                ->setDescription($faker->sentence(5))
                ->setAuthor($faker->name())
                ->setIsPublished($faker->boolean())
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 month', '-1 week')))
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 week', 'now')));

            $manager->persist($wish);
        }

        $manager->flush();
    }
}
