<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $categories = $manager->getRepository(Category::class)->findAll();
        for($i = 1; $i <= 42; $i++) {
            $post = new Post()
                ->setTitle($faker->words(rand(1, 3), true))
                ->setContent($faker->paragraphs(rand(2, 3), true))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days', 'now')))
                ->setImage($i.'.jpg')
                ->setIsPublished($faker->boolean(90))
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-10 days', 'now')))
                ->setCategory($faker->randomElement($categories));
            $manager->persist($post);
        }
        $manager->flush();
    }
}

