<?php

namespace App\DataFixtures;

use App\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LevelFixtures extends Fixture
{
    private array $level = ['Beginner', 'Midway','Advance'];
    public function load(ObjectManager $manager): void
    {
        foreach ($this->level as $level) {
            $newLevel = new Level();
            $faker = Factory::create();
            $newLevel->setName($level);
            $manager->persist($newLevel);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
