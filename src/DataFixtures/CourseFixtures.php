<?php

namespace App\DataFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Category;
use App\Entity\Course;
use App\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CourseFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly SluggerInterface
                                $slugger) {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $category = $manager->getRepository(Category::class)->findAll();
        $level = $manager->getRepository(Level::class)->findAll();
        for ($i = 1; $i < 32; $i++) {
            $course = new Course();
            $courseName = $faker->words($faker->numberBetween(5,6), true);
            $course->setCategory($faker->randomElement($category))
                ->setLevel($faker->randomElement($level))
                ->setName($courseName)
                ->setSmallDescription($faker->sentence($faker->numberBetween(10,20), true))
                ->setFullDescription($faker->paragraphs($faker->numberBetween(3,5), true))
                ->setDuration($faker->numberBetween(1,12))->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days', 'now')))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days', 'now')))
                ->setPublished($faker->boolean(90))
                ->setSlug($this->slugger->slug($courseName))
                ->setimage($i .'.jpg')
                ->setProgram( $this->slugger->slug($courseName) . ".pdf")
                ->setPrice($faker->numberBetween(200, 2900))
                ->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($course);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            LevelFixtures::class
        ];
    }
}
