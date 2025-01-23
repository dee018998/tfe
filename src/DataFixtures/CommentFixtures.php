<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Course;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $course = $manager->getRepository(Course::class)->findAll();
        $user = $manager->getRepository(User::class)->findAll();
        for ($i = 0; $i < 200; $i++) {
            $comment = new Comment();
            $comment->setUser($faker->randomElement($user))
                    ->setCourse($faker->randomElement($course))
                    ->setContent($faker->sentences($faker->numberBetween(1,4), true))
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days', 'now')))
                    ->setRating($faker->numberBetween(3,5))
                    ->setPublished(true)
                    ->setModarated(false);

            $manager->persist($comment);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CourseFixtures::class
        ];
    }
}
