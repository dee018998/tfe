<?php

namespace App\DataFixtures;

use App\Entity\Actu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class ActuFixtures extends Fixture
{

    public function __construct(private readonly SluggerInterface
                                $slugger) {
    }
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();
        for ($i = 1; $i < 17; $i++) {
            $actu = new Actu();
            $actuName = $faker->words($faker->numberBetween(5,11), true);
            $actu->setImage($i . '.jpg')
                ->setName($actuName)
                ->setContent($faker->paragraphs($faker->numberBetween(4,7), true))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days', 'now')))
                ->setPublished($faker->boolean(90))
                ->setimage($i .'.jpg')
                ->setSlug($this->slugger->slug($actuName));
            $manager->persist($actu);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
