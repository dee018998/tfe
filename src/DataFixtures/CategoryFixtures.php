<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    private array $categories = ['Hardware', 'Genre'];
    public function load(ObjectManager $manager): void
    {
        foreach ($this->categories as $category) {
            $cat = new Category();
            $faker = Factory::create();
            $cat->setName($category);
            $manager->persist($cat);

        }
        $manager->flush();
    }
}
